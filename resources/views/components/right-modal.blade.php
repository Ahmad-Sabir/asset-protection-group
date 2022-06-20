<div class="right-sidebar offcanvas offcanvas-end" tabindex="-1" id="{{ $id ?? 'modal' }}"
aria-labelledby="offcanvasRightLabel">
    <div class="right-sidebar-header">
        <h5>
            <a href="javascript:;" data-bs-dismiss="offcanvas"><em class="fa-solid fa-arrow-left"></em></a>
            {{ $heading ?? 'modal' }}
        </h5>
    </div>
    <div class="right-sidebar-content" id="{{ $id ?? 'modal' }}-body">
        {{ $slot }}
    </div>
</div>
