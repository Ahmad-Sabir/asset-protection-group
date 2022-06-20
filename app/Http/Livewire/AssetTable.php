<?php

namespace App\Http\Livewire;

use App\Models\Admin\Asset\Asset;
use App\Services\Admin\ExportService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AssetTable extends Component
{
    use WithPagination;

    /**
     * The attributes that are mass assignable.
     *
     * @var string|null
     */
    public $viewFile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $where = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public $whereHas = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * Listeners for component
     * @var array
     */
    protected $listeners = ['delete', 'manualFilter', 'export', 'csvExport'];

    /**
     * set filter
     * @var array
     */
    public $filter = [];

    /**
     * set filter status
     * @var bool
     */
    public $isFilter = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $mapData = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public $sortField = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var bool
     */
    public $sortAsc = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var null|int
     */
    public $companyId = null;


    /**
     * set purchase range
     * @var array
     */
    public $range_purchase_price = [];

    /**
     * set cost range
     * @var array
     */
    public $range_cost_price = [];

    /**
     * Livewire Lifecycle Hook
     *
     * @return void
     */
    public function updatingFilter()
    {
        $this->gotoPage(1);
    }

    /**
     * set filter params.
     *
     * @return void
     */
    public function mount()
    {
        $asset = Asset::when(!empty($this->where), function ($query) {
            $query->where($this->where);
        })->when(!empty($this->whereHas), function ($query) {
            $query->whereHas($this->whereHas);
        });

        $purchaseMinValue = $asset->min('purchase_price');
        $purchaseMaxValue = $asset->max('purchase_price');
        $purchaseRate = ['min' => (int) $purchaseMinValue, 'max' => (int) $purchaseMaxValue];
        $this->range_purchase_price = $purchaseRate;
        $this->filter['purchase_price'] = $purchaseRate;

        $costMinValue = $asset->min('replacement_cost');
        $costMaxValue = $asset->max('replacement_cost');
        $costRate = ['min' => (int) $costMinValue, 'max' => (int) $costMaxValue];
        $this->range_cost_price = $costRate;
        $this->filter['cost'] = $costRate;
    }

    /**
     * set filter params.
     *
     * @return void
     */
    public function filter()
    {
        $this->isFilter = true;
    }

    /**
     * export pdf
     * @param mixed $type
     *
     * @return mixed
     */
    public function export($type)
    {
        $pdfTemplate = config('apg.pdf_options.template.asset-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        app(ExportService::class)->export(
            $this->assets()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            [],
            $type,
            [
                'fileName' => __('messages.export_filename.assets'),
                'isLocation' => true,
                'emailView' => 'email-template.exports.master-asset-bulk'
            ]
        );
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * export csv
     * @param mixed $type
     * @param mixed $assetType
     *
     * @return mixed
     */
    public function csvExport($type, $assetType)
    {
        $module = [
            'module' => config('apg.export_module.master_asset'),
            'fileName' => __('messages.export_filename.assets'),
            'assetType' => $assetType ?? '',
            'isLocation' => true,
            'emailView' => 'email-template.exports.master-asset-bulk'
        ];
        app(ExportService::class)->export($this->assets()->get(), [], [], $this->filter, [], $type, $module);
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        $this->filter = [];
        $this->filter['cost'] = $this->range_cost_price;
        $this->filter['purchase_price'] = $this->range_purchase_price;
    }

    /**
     * set manualFilter filter.
     *
     * @param string $key
     * @param string $value
     * @param array $data
     * @return void
     */
    public function manualFilter($key, $value, $data = [])
    {
        $this->filter[$key] = $value;
        $this->filter['custom_asset_type'] = $data['name'] ?? null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param string $field
     * @return void
     */
    public function sortBy($field = "id")
    {
        $this->sortAsc = ($this->sortField === $field)
        ? (! $this->sortAsc) : true;

        $this->sortField = $field;
    }

    /**
     * assets
     *
     * @return mixed
     */
    public function assets()
    {
        return app(\App\Services\Admin\Asset\AssetService::class)
        ->getAssets($this->filter)
        ->with([
        'location' => function ($query) {
            $query->select('*');
        },
        'medias' => function ($query) {
            $query->where('ext', 'webp')
            ->latest()
            ->limit(1);
        },
        'company:id,name,profile_media_id',
        'assetType:id,name'
        ])->when(!empty($this->where), function ($query) {
                $query->where($this->where);
        })->when(!empty($this->whereHas), function ($query) {
                $query->whereHas($this->whereHas);
        })->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $assets = $this->assets()->paginate($this->perPage);
        $this->mapData = [];
        foreach ($assets as $key => $value) {
            if ($value->location) {
                $this->mapData[$key]['asset_id'] = $value->id;
                $this->mapData[$key]['name'] = $value->name;
                $this->mapData[$key]['latitude'] = $value->location->latitude;
                $this->mapData[$key]['longitude'] = $value->location->longitude;
                $this->mapData[$key]['url'] = $value->medias->first()?->url;
            }
        }

        /** @phpstan-ignore-next-line */
        return view($this->viewFile, [
            'data' => $assets,
            'mapData' => $this->mapData,
            'companyId' => $this->companyId
        ]);
    }

    public function delete(mixed $id): void
    {
        /** @var \App\Models\Admin\Asset\Asset $asset */
        $asset = Asset::find($id);
        $asset->delete();

        $this->emit('closeModal');
    }
}
