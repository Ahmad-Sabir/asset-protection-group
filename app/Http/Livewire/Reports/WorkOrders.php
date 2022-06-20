<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\ExportService;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Services\Admin\FilterReportService;

class WorkOrders extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected const SESSION_CUSTOMIZE_FIELD = 'work_order_report.customizeField';

    /**
     * @var string
     */
    public const SESSION_FILTER = 'work_order_report.filter';

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
        'exportPdfReportWorkOrder',
        'exportCsvReportWorkOrder',
        'manualFilter',
        'filter'
    ];

     /**
     *
     * @return void
     */
    public function mount()
    {
        $this->customizeField = config('apg.work_order_report_fields');
        if (Session::has(self::SESSION_FILTER)) {
            $this->filter = Session::get(self::SESSION_FILTER);
        }
        if (Session::has(self::SESSION_CUSTOMIZE_FIELD)) {
            $this->customizeField = Session::get(self::SESSION_CUSTOMIZE_FIELD);
        }
    }

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
     * export report work order pdf
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportPdfReportWorkOrder($fields, $type)
    {
        $pdfTemplate = config('apg.pdf_options.template.report-work-order-print');
        $orientation = config('apg.pdf_options.orientation.landscape');
        app(ExportService::class)->export(
            $this->reportWorkOrder()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            $fields,
            $type,
            ['fileName' => __('messages.export_filename.work_order_reports')]
        );
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * export report work order csv
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportCsvReportWorkOrder($fields, $type)
    {
        $module = [
            'module' => config('apg.export_module.report_workorder'),
            'fileName' => __('messages.export_filename.work_order_reports')
        ];
        app(ExportService::class)->export(
            $this->reportWorkOrder()->get(),
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
     * set clear params.
     *
     * @param array $customizeField
     * @return void
     */
    public function filter($customizeField = [])
    {
        Session::put(self::SESSION_CUSTOMIZE_FIELD, $customizeField);
    }

    /**
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        $this->customizeField = config('apg.work_order_report_fields');
        Session::put(self::SESSION_CUSTOMIZE_FIELD, $this->customizeField);
        $this->filter = [];
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
            'type' => config('apg.report_types.work_orders'),
            'filter' => json_encode($this->filter)
        ]);
    }

    /**
     * set save filters.
     *
     * @param array $filters
     * @return void
     */
    public function customizeFilter($filters)
    {
        $this->filter = isset($filters['filter']) ? json_decode($filters['filter'], true) : [];
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
     * report work order
     *
     * @return mixed
     */
    public function reportWorkOrder()
    {
        /** @phpstan-ignore-next-line */
        return WorkOrder::with(['assets', 'assetType'])
        ->whereNotNull('company_id')
        ->where('type', config('apg.type.company'))
        ->whereHas('company')
        ->whereHas('asset')
        ->when(!empty($this->filter), function ($query) {
            $query->where(function ($query) {
                foreach ($this->filter as $field => $value) {
                    $value = trim($value);
                    $query->when($field == 'global_search' && !empty($value), function ($query) use ($value) {
                        $query->where(function ($query) use ($value) {
                            $query->where('id', $value)
                            ->orWhere('title', 'like', "%$value%");
                        });
                    })->when($field == 'company_id' && $value != '', fn ($query) => $query->whereCompanyId($value))
                    ->when($field == 'assigned' && !empty($value), function ($query) use ($value) {
                        $query->whereHas('user', function ($query) use ($value) {
                            $query->Where('id', $value);
                        });
                    })->when($field == 'asset_type', function ($query) use ($value) {
                        $query->whereHas('assetType', function ($query) use ($value) {
                            $query->Where('name', 'like', "%$value%");
                        });
                    })->when($field == 'work_order_status' && !empty($value), function ($query) use ($value) {
                        $query->where('work_order_status', $value);
                    })->when($field == 'work_order_type' && !empty($value), function ($query) use ($value) {
                        $query->where('work_order_type', $value);
                    })->when($field == 'due_date' && !empty($value), function ($query) use ($value) {
                        $range = parseRangeDate($value);
                        $query->whereBetween(DB::raw('DATE(due_date)'), [
                            $range['start_date'],
                            $range['end_date']
                        ]);
                    })->when($field == 'updated_at' && !empty($value), function ($query) use ($value) {
                        $range = parseRangeDate($value);
                        $query->whereBetween(DB::raw('DATE(updated_at)'), [
                            $range['start_date'],
                            $range['end_date']
                        ]);
                    })->when($field == 'location' && $value != '', function ($query) use ($value) {
                        $query->WhereHas('asset', function ($query) use ($value) {
                            $query->whereHas('location', fn ($query) => $query->where('name', 'like', "%$value%"));
                        });
                    });
                }
            });
        })->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        Session::put(self::SESSION_FILTER, $this->filter);
        return view("livewire.reports.work-orders", [
            'workOrders' => $this->reportWorkOrder()->paginate($this->perPage),
            'customizeField' => $this->customizeField
        ]);
    }

    public function hydrate(mixed $memo): void
    {
        $payload = Arr::get($memo->updates[0] ?? [], 'payload', []);
        $this->isClear = false;
        if (isset($payload['method']) && $payload['method'] == 'clear') {
            $this->isClear = true;
        }
    }
}
