<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="table-border">
        <div class="entries">
            <div class="form-group">
                <x-label class="text-b">Showing</x-label>
                <select class="form-select" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
        </div>
        <table class="admin-table" aria-label="">
            <thead>
                <tr>
                    <th scope="col" class="">
                        File Name
                    </th>
                    <th scope="col" class="">
                        Upload Date
                    </th>
                    <th scope="col" class="">

                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medias as $media)
                <tr class="border-b">
                    <td>{{ $media->name }}</td>
                    <td>{{ customDateFormat($media->created_at) }}</td>
                    <td>
                        <a href="{{ $media->url }}" download="{{ $media->name }}"><em class="fa-solid fa-download"></em></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No Record Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $medias->links() }}
    </div>
</div>
