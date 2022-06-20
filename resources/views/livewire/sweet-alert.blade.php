@pushOnce('style')
<link rel="stylesheet" href="{{ url('assets/sweetalert/sweetalert.css') }}">
@endPushOnce
<div></div>
@pushOnce('script')
<script src="{{ asset('assets/sweetalert/sweetalert.min.js') }}"></script>
<script>
    window.livewire.on('openAlert', (data) => {
         swal({
            title: data.title,
            text: data.description,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-secondary',
            cancelButtonClass: 'btn-primary',
            confirmButtonText: 'Yes',
            closeOnConfirm: false,
          },
          function(){
            window.livewire.emitTo(data.component, data.action, data.id)
            swal({
                title: "Success!",
                text: data.success_msg,
                type: "success",
            });
          });
    });
</script>
@endPushOnce
