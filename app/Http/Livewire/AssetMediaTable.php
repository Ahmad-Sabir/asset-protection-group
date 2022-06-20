<?php

namespace App\Http\Livewire;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;

class AssetMediaTable extends Component
{
    use WithPagination;

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $where = [];

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        /** @phpstan-ignore-next-line */
        $medias = Media::whereHas('assetMedias', fn ($query) => $query->where($this->where))
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view("admin.asset.media-table", [
            'medias' => $medias,
        ]);
    }
}
