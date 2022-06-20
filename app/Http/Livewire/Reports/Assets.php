<?php

namespace App\Http\Livewire\Reports;

use App\Models\Media;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use App\Models\Admin\Asset\Asset;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\ExportService;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\FilterReportService;

class Assets extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected const SESSION_CUSTOMIZE_FIELD = 'asset_report.customizeField';

    /**
     * @var string
     */
    public const SESSION_FILTER = 'asset_report.filter';

    /**
     * @var bool
     */
    public $isClear = false;

    /**
     * set filter
     * @var array
     */
    public $filter = [];

    /**
     * set customize table
     * @var array
     */
    public $customizeField = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

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
     * set filter name
     * @var null
     */
    public $filterName = null;

    /**
     * Listeners for component
     * @var array
     */
    protected $listeners = [
        'customizeFilter',
        'exportPdfReportAsset',
        'exportCsvReportAsset',
        'manualFilter',
        'filter'
    ];

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
     * export report asset pdf
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportPdfReportAsset($fields, $type)
    {
        $pdfTemplate = config('apg.pdf_options.template.report-asset-print');
        $orientation = config('apg.pdf_options.orientation.landscape');
        app(ExportService::class)->export(
            $this->reportAssets()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            $fields,
            $type,
            ['fileName' => __('messages.export_filename.asset_reports'), 'isLocation' => true]
        );
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * export report asset csv
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportCsvReportAsset($fields, $type)
    {
        $module = [
            'module' => config('apg.export_module.report_asset'),
            'fileName' => __('messages.export_filename.asset_reports'),
            'isLocation' => true
        ];
        app(ExportService::class)->export(
            $this->reportAssets()->get(),
            [],
            [],
            $this->filter,
            $fields,
            $type,
            $module
        );
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * set filter params.
     *
     * @return void
     */
    public function mount()
    {
        $this->customizeField = config('apg.asset_report_fields');
        $asset = Asset::whereNotNull('company_id');

        $costMinValue = $asset->min('replacement_cost');
        $costMaxValue = $asset->max('replacement_cost');
        $costRate = ['min' => (int) $costMinValue, 'max' => (int) $costMaxValue];
        $this->range_cost_price = $costRate;
        $this->filter['cost'] = $costRate;

        $purchaseMinValue = $asset->min('purchase_price');
        $purchaseMaxValue = $asset->max('purchase_price');
        $purchaseRate = ['min' => (int) $purchaseMinValue, 'max' => (int) $purchaseMaxValue];
        $this->range_purchase_price = $purchaseRate;
        $this->filter['purchase_price'] = $purchaseRate;

        if (Session::has(self::SESSION_FILTER)) {
            $this->filter = Session::get(self::SESSION_FILTER);
        }
        if (Session::has(self::SESSION_CUSTOMIZE_FIELD)) {
            $this->customizeField = Session::get(self::SESSION_CUSTOMIZE_FIELD);
        }
    }

    /**
     * save filters.
     *
     * @return void
     */
    public function saveFilter()
    {
        $this->validate([
            'filterName' => 'required|max:255',
        ]);
        app(FilterReportService::class)->store([
            'name' => $this->filterName,
            'type' => config('apg.report_types.assets'),
            'filter' => json_encode($this->filter)
        ]);
    }

    /**
     * set clear params.
     *
     * @param array $filters
     * @return void
     */
    public function customizeFilter($filters)
    {
        $this->filter = isset($filters['filter']) ? json_decode($filters['filter'], true) : [];
        $this->customizeRange();
    }

     /**
     * set manualFilter filter.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function manualFilter($key, $value)
    {
        $this->filter[$key] = $value;
    }

    /**
     * set clear params.
     *
     * @param array $customizeField
     * @return void
     */
    public function filter($customizeField = [])
    {
        Session::put(self::SESSION_CUSTOMIZE_FIELD, $customizeField);
        $this->customizeRange();
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
        $this->customizeField = config('apg.asset_report_fields');
        Session::put(self::SESSION_CUSTOMIZE_FIELD, $this->customizeField);
    }

    /**
     * set save filters.
     *
     * @return void
     */
    public function customizeRange()
    {
        $cost = Arr::get($this->filter, 'cost');
        $purchasePrice = Arr::get($this->filter, 'purchase_price');
        if ($cost) {
            Arr::set($this->filter, 'cost.min', min(intval($cost['min']), intval($cost['max'])));
            Arr::set($this->filter, 'cost.max', max(intval($cost['min']), intval($cost['max'])));
        }
        if ($purchasePrice) {
            Arr::set(
                $this->filter,
                'purchase_price.min',
                min(
                    intval($purchasePrice['min']),
                    intval($purchasePrice['max'])
                )
            );
            Arr::set(
                $this->filter,
                'purchase_price.max',
                max(
                    intval($purchasePrice['min']),
                    intval($purchasePrice['max'])
                )
            );
        }
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
     * report assets
     *
     * @return mixed
     */
    public function reportAssets()
    {
        return app(\App\Services\Admin\Asset\AssetService::class)
        ->getAssets($this->filter)
        ->with([
        'location' => function ($query) {
            $query->select('*');
        },
        'company:id,name',
        'assetType:id,name'
        ])->whereNotNull('company_id')
        ->where('type', config('apg.type.company'))
        ->whereHas('company')
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        Session::put(self::SESSION_FILTER, $this->filter);
        return view("livewire.reports.assets", [
            'assets' => $this->reportAssets()->paginate($this->perPage),
            'customizeField' => $this->customizeField
        ]);
    }

    public function hydrate(mixed $memo): void
    {
        $this->isClear = false;
        $payload = Arr::get($memo->updates[0] ?? [], 'payload', []);
        if (isset($payload['method']) && $payload['method'] == 'clear') {
            $this->isClear = true;
        }
    }
}
