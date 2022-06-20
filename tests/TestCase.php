<?php

namespace Tests;

use App\Models\User;
use App\Models\Media;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    /**
     * This var hold user.
     *
     * @var mixed
     */
    protected $user;

    /**
     * This var hold media.
     *
     * @var mixed
     */
    protected $media;

    /**
     * This var hold products.
     *
     * @var mixed
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->media = Media::create([
            'url'              => "/medias/test.jpg",
            'name'             => "test media",
            'hash'             => "testmedia.jgp",
            'size'             => "100",
            'ext'              => "jpg",
            'is_internal_file' => 1,
            'width'            => 200,
            'height'           => 100
        ]);
    }
}
