<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\MediaService;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService,
    ) {
    }

    /**
     * Store a new resource.
     *
     * @param Request $request
     * @return BaseResponse object;
     */
    public function store(Request $request)
    {
        $media = $this->mediaService->store($request);

        return new BaseResponse(
            STATUS_CODE_OK,
            __('messages.create', ['title' => 'Media']),
            $media
        );
    }

     /**
     * Store a new resource.
     *
     * @param int $id
     * @return BaseResponse object;
     */
    public function destroy($id)
    {
        $this->mediaService->destroy($id);

        return new BaseResponse(
            STATUS_CODE_OK,
            __('messages.delete', ['title' => 'Media']),
            []
        );
    }
}
