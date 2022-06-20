<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="{{ $id ?? 'modal' }}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            {{ $slot }}
        </div>
    </div>
</div>
