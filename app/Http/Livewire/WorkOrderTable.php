<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Admin\Asset\AssetController;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Company;
use App\Services\Admin\ExportService;
use Illuminate\Support\Carbon;

class WorkOrderTable extends Component
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
     * @var int
     */
    public $perPage = 10;

    /**
     * Listeners for component
     * @var array
     */
    protected $listeners = ['delete', 'export', 'exportComprehensive', 'csvExport', 'manualFilter'];

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
     * set filter status
     * @var mixed
     */
    public $asset = [];

    /**
     * set company id
     * @var null
     */
    public $companyId = null;

    /**
     * set color
     * @var string
     */
    public $color = 'messages.livewire_message.color';

    /**
     * set msg
     * @var string
     */
    public $msg = 'messages.livewire_message.message';

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
     * @param mixed $date
     * @return void
     */
    public function dateFilter($date)
    {
        $month = Carbon::now()->format('F');
        if ($date == 'current_month') {
            $this->filter['current_month'] = $month;
        } elseif ($date == 'current_year') {
            $this->filter['current_year'] = now()->year;
        }
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
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        $this->filter = [];
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
     * export
     * @param mixed $type
     *
     * @return mixed
     */
    public function export($type)
    {
        $pdfTemplate = config('apg.pdf_options.template.work-order-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        app(ExportService::class)->export(
            $this->workOrders()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            [],
            $type,
            [
                'fileName' => __('messages.export_filename.work_orders'),
                'isLocation' => true,
                'emailView' => 'email-template.exports.master-workorder-bulk'
            ]
        );
        $message = [
            'color'     => __($this->color, ['color' => 'success']),
            'message'   => __($this->msg)
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * export csv
     * @param mixed $type
     *
     * @return mixed
     */
    public function csvExport($type)
    {
        $module = [
            'module' => config('apg.export_module.master_workorder'),
            'fileName' => __('messages.export_filename.work_orders'),
            'isLocation' => true,
            'emailView' => 'email-template.exports.master-workorder-bulk'
        ];
        app(ExportService::class)->export($this->workOrders()->get(), [], [], $this->filter, [], $type, $module);
        $message = [
            'color'     => __($this->color, ['color' => 'success']),
            'message'   => __($this->msg)
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * exportComprehensive
     * @param mixed $type
     * @param mixed $companyId
     *
     * @return mixed
     */
    public function exportComprehensive($type, $companyId = '')
    {
        $company = Company::where('id', $companyId)->first();
        app(\App\Services\Admin\ExportService::class)->export(
            [],
            'asset-comprehensive-print',
            'landscape',
            $this->filter,
            '',
            $type,
            [
                'module' => 'comprehensive',
                'fileName' => __('messages.export_filename.work_order_comprehensive'),
                'where' => $this->where,
                'emailView' => 'email-template.exports.comprehensive',
                'company' => $company->profile?->hash ?? ''
            ]
        );
        $message = [
            'color'     => __($this->color, ['color' => 'success']),
            'message'   => __($this->msg)
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
    }

    /**
     * workOrders
     *
     * @return mixed
     */
    public function workOrders()
    {
        $with = [
            'location' => function ($query) {
                $query->select('*');
            },
            'assets',
            'assetType',
            'company',
            'additionaltasks'
        ];
        if (! empty($this->asset)) {
            $with = ['user'];
        }

        /** @phpstan-ignore-next-line */
        return WorkOrder::with($with)
        ->when(!empty($this->where), function ($query) {
            $query->Where($this->where);
        })->when(!empty($this->asset), function ($query) {
            $query->where(function ($query) {
                $query->whereHas('asset', fn ($query) => $query->where('id', $this->asset->id));
            });
        })->when($this->companyId, fn ($q) => $q->whereHas('asset'))
        ->when($this->isFilter && !empty($this->filter), function ($query) {
            $query->filter($this->filter);
        })->when(!empty($this->asset), function ($query) {
            $query->orderByRaw("
                FIELD(work_order_type,
                    'Recurring',
                    'Non Recurring'
                ),
                FIELD(work_order_frequency,
                    'Daily',
                    'Bi-weekly',
                    'Weekly',
                    'Bi-Monthly',
                    'Monthly',
                    'Quarterly',
                    'Semi-Annually',
                    'Annually'
                )
            ");
        })->when(empty($this->asset), function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        /** @phpstan-ignore-next-line */
        return view($this->viewFile, [
            'data' => $this->workOrders()->paginate($this->perPage),
            'companyId' => $this->companyId,
        ]);
    }

    public function delete(mixed $id): void
    {
        /** @var \App\Models\Admin\WorkOrder\WorkOrder $workOrder  */
        $workOrder = WorkOrder::find($id);
        $workOrder->delete();

        $this->emit('closeModal');
    }
}
