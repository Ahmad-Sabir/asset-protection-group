<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use App\Models\Admin\Asset\Location;
use App\Services\Admin\ExportService;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\FilterReportService;

class Table extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected const SESSION_CUSTOMIZE_FIELD = 'company_report.customizeField';

    /**
     * @var string
     */
    public const SESSION_FILTER = 'company_report.filter';

    /**
     * The attributes that are mass assignable.
     *
     * @var string|null
     */
    public $viewFile;

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public $model = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var null|array
     */
    public $relations = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $where = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var bool
     */
    public $autoSaveFilter = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var bool
     */
    public $isClear = false;

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
     * @var null
     */
    public $filterName = null;

     /**
     * Listeners for component
     * @var array
     */
    protected $listeners = ['delete', 'customizeFilter', 'exportPdfReportCompany', 'exportCsvReportCompany', 'filter'];

    /**
     * set customize table
     * @var array
     */
    public $customizeField = [];

    /**
     *
     * @return void
     */
    public function mount()
    {
        if ($this->autoSaveFilter) {
            $this->customizeField = config('apg.company_report_fields');
            if (Session::has(self::SESSION_FILTER)) {
                $this->filter = Session::get(self::SESSION_FILTER);
            }
            if (Session::has(self::SESSION_CUSTOMIZE_FIELD)) {
                $this->customizeField = Session::get(self::SESSION_CUSTOMIZE_FIELD);
            }
        }
    }

    /**
     * export
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportPdfReportCompany($fields, $type)
    {
        $pdfTemplate = config('apg.pdf_options.template.report-company-print');
        $orientation = config('apg.pdf_options.orientation.landscape');
        app(ExportService::class)->export(
            $this->reportCompanies()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            $fields,
            $type,
            ['fileName' => __('messages.export_filename.company_reports')]
        );
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * get company report csv
     *
     * @param mixed $fields
     * @param mixed $type
     * @return mixed
     */
    public function exportCsvReportCompany($fields, $type)
    {
        $module = [
            'module' => config('apg.export_module.report_company'),
            'fileName' => __('messages.export_filename.company_reports')
        ];
        app(ExportService::class)->export(
            $this->reportCompanies()->get(),
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
     * Livewire Lifecycle Hook
     *
     * @return void
     */
    public function updatingFilter()
    {
        $this->gotoPage(1);
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
            'type' => config('apg.report_types.users'),
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
     * set filter params.
     *
     * @param array $customizeField
     * @return void
     */
    public function filter($customizeField = [])
    {
        if ($this->autoSaveFilter) {
            Session::put(self::SESSION_CUSTOMIZE_FIELD, $customizeField);
        }
        $this->isFilter = true;
    }

    /**
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        if ($this->autoSaveFilter) {
            $this->customizeField = config('apg.company_report_fields');
            Session::put(self::SESSION_CUSTOMIZE_FIELD, $this->customizeField);
        }
        $this->filter = [];
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
     * report companies
     *
     * @return mixed
     */
    public function reportCompanies()
    {
        return app($this->model)
        ->select('*')
        ->with($this->relations ?? [])
        ->when(!empty($this->where), function ($query) {
            $query->Where($this->where);
        })->when($this->isFilter && !empty($this->filter), function ($query) {
            $query->where(function ($query) {
                foreach ($this->filter as $field => $value) {
                    $range = [];
                    if ($field == 'range_created_at') {
                        $range = parseRangeDate($value);
                    }
                    $value = trim($value);
                    $query->when(!empty($value) || $value == 0, function ($query) use ($field, $value, $range) {
                        $childWhere = $this->searchFilter($field, $value, $range);
                        $query->whereRaw($childWhere);
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
        if ($this->autoSaveFilter) {
            Session::put(self::SESSION_FILTER, $this->filter);
        }

        /** @phpstan-ignore-next-line */
        return view($this->viewFile, [
            'data' => $this->reportCompanies()->paginate($this->perPage),
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

    /**
    * searchFilter
    * @param mixed $field
    * @param mixed $value
    * @param mixed $range
    * @return string
    */
    public function searchFilter($field, $value, $range)
    {
        $value = htmlspecialchars($value);
        return match ($field) {
                'full_name_search'  => app()->environment('testing') ?
                "first_name || ' ' || last_name like '%$value%'" : "concat(first_name, ' ', last_name)
                like '%$value%'",
                'range_created_at'  => "date(created_at) between
                '" . $range['start_date'] . "' and '" . $range['end_date'] . "'",
                'deactivate_at' => $value == 1 ? "deactivate_at IS NULL" : "deactivate_at IS NOT NULL",
                'id_and_name' => ("id = '$value' or name like '%$value%'"),
                default  => "$field like '%$value%'"
        };
    }

    public function edit(mixed $data): void
    {
        if (isset($data['view_file'])) {
            $data = view($data['view_file'], ['data' => $data])->render();
        }
        $this->dispatchBrowserEvent('edit-modal', $data);
    }

    public function delete(mixed $id): void
    {
        if ($this->model == User::class &&  auth()->id() == $id) {
            $this->emit('closeModal');

            return;
        }
        $data = app($this->model)
        ->when($this->model == Location::class, fn ($query) => $query->withoutGlobalScope('lat_lng'))
        ->find($id);
        $data?->delete();

        $this->emit('closeModal');
    }
}
