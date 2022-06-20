<?php

namespace App\Services\Admin;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Hold model of media
     * @var \App\Models\Media $media
     */
    protected $media;

    /**
     * Default constructor to load data and view
     * @param \App\Models\Media $media
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * Store a new resource
     *
     * @param Request $request
     * @return mixed
     */
    public function store($request)
    {
        if (is_array($request->file)) {
            $data = [];
            foreach ($request->file as $file) {
                $params = new Request();
                $params->files->add(["file" => $file]);
                $data[] = $this->storeFiles($params);
            }
        } else {
            $data = $this->storeFiles($request);
        }

        return $data;
    }

    /**
     * Store a new resource
     *
     * @param Request $request
     * @return object
     */
    public function storeFiles($request)
    {
        $ext = $request->file->getClientOriginalExtension();
        $is_internal_file = $width = $height = 0;

        if (!$request->has('url') && $request->file) {
            $file_name = 'medias/' . hash('sha256', Str::uuid()->toString());
            $is_internal_file = 1;

            if (in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
                $ext = 'webp';
                $originalImage = Image::make($request->file('file'));
                $width  = $originalImage->getWidth();
                $height = $originalImage->getHeight();
            }

            $file_name .= '.' . $ext;

            /**
             * @var resource|string $content
             */
            $content = file_get_contents($request->file);
            Storage::put($file_name, $content);

            $request->merge([
                'size' => $request->file->getSize(),
                'url'  => $file_name,
                'hash' => $file_name,
                'name' => $request->file->getClientOriginalName()
            ]);
        }

        $request->merge([
            "ext"               => $ext,
            "is_internal_file"  => $is_internal_file,
            "width"             => $width,
            "height"            => $height
        ]);

        return $this->media->create($request->only(
            'url',
            'name',
            'hash',
            'size',
            'ext',
            'is_internal_file',
            'width',
            'height'
        ));
    }

    /**
     * Update a single resource
     *
     * @param int $id
     * @return bool|null
     */
    public function destroy($id)
    {
        /**
         * @var \App\Models\Media|null $data
         */
        $data = $this->media->find($id);

        if (isset($data->id)) {
            Storage::delete($data->url);
        }

        return $data?->delete();
    }

    /**
     * clone media
     *
     * @param array $ids
     * @return array
     */
    public function clone($ids)
    {
        $mediaId = [];
         /**
         * @var \App\Models\Media $medias
         */
        $medias = $this->media->whereIn('id', $ids)->get();
        $medias->each(function ($media) use (&$mediaId) {
            $oldFileName = $media->hash;
            $newFileName = 'medias/' . hash('sha256', Str::uuid()->toString()) . '.' . $media->ext;
            Storage::copy($oldFileName, $newFileName);
            $newMedia = $media->replicate()->fill([
                'url' => $newFileName,
                'hash' => $newFileName,
            ]);
            $newMedia->save();
            $mediaId[] = $newMedia->id;
        });

        return $mediaId;
    }
}
