@pushOnce('style')
<link rel="stylesheet" href="{{ '/css/dropzone.css' }}">
@endPushOnce
@php
    $media_element_id = $id ?? 'media_id';
    $media_element_name = $name ?? 'media_id';
    $dropzoneId = "file-dropzone-{$media_element_id}";
    $avatarId = "avatar-{$media_element_id}";
@endphp
@if(isset($multiFiles))
<div class="dropzone-wrap multi-upload">
    <div class="dropzone" id="{{ $dropzoneId }}">
        <div class="dz-message" data-dz-message>
            <x-button type="button"><em class="fa-solid fa-upload"></em>Upload Image</x-button>
        </div>
    </div>
</div>
<div id="files-{{$media_element_id}}">
    @foreach($medias ?? [] as $file)
        <input type="hidden" name="{{$id}}[]" id="{{$id}}-{{$file->id}}" value="{{$file->id ?? ''}}">
    @endforeach
</div>
@else
<div class="dropzone-wrap upload-profile">
    <div class="dropzone" id="{{ $dropzoneId }}">
        <span class="avatar" id="{{ $avatarId }}"><img src="{{ asset('assets/images/avatar.png') }}" alt="avatar" /></span>
        <div class="dz-message" data-dz-message>
            <x-button class="btn-outline-primary" type="button">Upload</x-button>
        </div>
    </div>
</div>
<input type="hidden" name="{{$media_element_name}}" id="{{$media_element_id}}" value="{{$media->id ?? ''}}">
@endif

@pushOnce('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
@endPushOnce
@push('script')
<script>
    var multiFiles = "{{$multiFiles ?? 1}}";
    Dropzone.autoDiscover = false;
    var currentFile = null;
    new Dropzone(document.getElementById('{{$dropzoneId}}'), {
        url: "{{ route('admin.media.store') }}",
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.xls,.doc,.ppt,.xlsx,.docx,.pptx,.pdf,.csv,.webp,.txt",
        addRemoveLinks: true,
        maxFilesize: 200,
        uploadMultiple: +multiFiles > 1 ? true : false,
        maxFiles: +multiFiles,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function()
        {
            this.on("addedfile", function(file, response)
            {
                @if (!isset($multiFiles))
                    document.getElementById("{{ $avatarId }}").style.display = "none";
                    if (currentFile && document.getElementById("{{$media_element_id}}").value) {
                        this.removeFile(currentFile);
                    }
                    currentFile = file;
                @endif
            });
            @isset ($media)
                var mockFile = { name: "{{$media->name}}", size: {{$media->size}}, type: 'image/jpg', media_id: {{$media->id}} };
                this.addFile.call(this, mockFile);
                this.emit('thumbnail', mockFile, "{{$media->url}}");
                mockFile.previewElement.classList.add('dz-complete');
            @endisset
            @isset ($medias)
            @foreach($medias ?? [] as $media)
                var mockFile = { name: "{{$media->name}}", size: {{$media->size}}, type: 'image/jpg', media_id: {{$media->id}} };
                this.options.addedfile.call(this, mockFile);
                this.options.thumbnail.call(this, mockFile, "{{$media->url}}");
                mockFile.previewElement.classList.add('dz-complete');
            @endforeach
            @endisset
        },
        error: function(e) {
            if (e.xhr !== undefined) {
                if (e.xhr.status === 413) {
                    setToastrAlert('error', 'Entity is too large');
                } else {
                    setToastrAlert('error', e.xhr.message);
                }
            }
        },
        removedfile: function(file)
        {
            let name = file.upload?.filename;
            let media_id = (file && file.media_id === undefined) ? document.getElementById("{{$media_element_id}}").value : file.media_id;
            let routeName = '{{ route("admin.media.destroy", ":id") }}';
            routeName = routeName.replace(':id', media_id);
            axios.delete(routeName).then(data => {
                if(multiFiles > 1) {
                    document.getElementById("{{$media_element_id}}-"+media_id).remove();
                } else {
                    document.getElementById("{{$media_element_id}}").value = null;
                }
            })
            .catch(error => {
                console.log(error);
            });
            if (file.previewElement != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }

            if (document.querySelectorAll('#{{$dropzoneId}} .dz-image').length == 0) {
                document.getElementById("{{ $avatarId }}").style.display = "block";
            }

            return void 0;
        },
        @if (!isset($multiFiles))
        success: function (file, response) {
            document.getElementById("{{$media_element_id}}").setAttribute('value', response.data.id)
        },
        @else
        successmultiple: function (files, response) {
            for (const i in files) {
                files[i].media_id = response.data[i].id
            }
            response.data.forEach(el=> {
                var files = document.getElementById('files-{{$media_element_id}}');
                files.insertAdjacentHTML('beforeend', `<input type="hidden" name="{{$media_element_name}}[]" id="{{$media_element_id}}-${el.id}" value="${el.id}">`);
            })
        }
      @endif
    });
</script>
@endpush
