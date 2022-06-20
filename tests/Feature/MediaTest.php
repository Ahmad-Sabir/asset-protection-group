<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;

class MediaTest extends TestCase
{
    protected const ASSET_ROUTE = 'admin.medias';

    public function test_manage_admin_medias()
    {
        $files = UploadedFile::fake()->image('slide_image.jpg');
        $this->actingAs($this->user)
        ->post(route('admin.media.store'), [
            "file" => $files,
        ])->assertOk();

        $this->actingAs($this->user)
        ->post(route('admin.media.store'), [
            "file" => [$files],
        ])->assertOk();

        $media = Media::first();
        $this->actingAs($this->user)
        ->delete(route('admin.media.destroy', $media->id))->assertOk();
    }
}
