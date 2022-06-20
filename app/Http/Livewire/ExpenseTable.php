<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Livewire\Component;
use App\Services\Admin\ExportService;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ExpenseTable extends Component
{
    use WithPagination;

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
     * set amount
     * @var array
     */
    public $amount = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public $companyId = '';

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
    protected $listeners = ['delete', 'manualFilter', 'pdfExport', 'csvExport'];

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
        if ($this->companyId) {
            $minValue = Expense::where('company_id', $this->companyId)->min('amount');
            $maxValue = Expense::where('company_id', $this->companyId)->max('amount');
            $rate = ['min' => (int) $minValue, 'max' => (int) $maxValue];
            $this->amount = $rate;
            $this->filter['amount'] = $rate;
        }
    }
     /**
     * pdfExport
     * @param mixed $type
     *
     * @return mixed
     */
    public function pdfExport($type)
    {
        $pdfTemplate = config('apg.pdf_options.template.expense-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        app(ExportService::class)->export(
            $this->expenses()->get(),
            $pdfTemplate,
            $orientation,
            $this->filter,
            [],
            $type,
            [
                'fileName' => __('messages.export_filename.expense'),
                'emailView' => 'email-template.exports.expense-bulk',
                'module' => config('apg.export_module.expense'),
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
     * @param mixed $format
     * @param mixed $type
     *
     * @return mixed
     */
    public function csvExport($format, $type)
    {
        $module = [
            'module' => config('apg.export_module.expense'),
            'fileName' => __('messages.export_filename.expense'),
            'company' => $type,
            'emailView' => 'email-template.exports.expense-bulk'
        ];
        app(ExportService::class)->export($this->expenses()->get(), [], [], $this->filter, [], $format, $module);
        $message = [
            'color'     => __('messages.livewire_message.color', ['color' => 'success']),
            'message'   => __('messages.livewire_message.message')
        ];
        $this->dispatchBrowserEvent('livewire-alert', $message);
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
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        $this->filter = [];
        $this->filter['amount'] = $this->amount;
    }
    /**
     *
     * @return mixed
     */
    public function expenses()
    {
        /** @phpstan-ignore-next-line */
        return Expense::whereHas('workOrder')->with(['workOrder' => fn ($query) =>
        $query->select('id', 'number', 'asset_id', 'assignee_user_id')
        ->with('asset', function ($query) {
         $query->select('id', 'number', 'location_id')
        ->with('location', fn ($q) => $q->select('id', 'name'));
        }), 'company' => fn ($query) => $query->select('id', 'profile_media_id')])
        ->when(!empty($this->where), function ($query) {
            $query->Where($this->where);
        })->when($this->isFilter && !empty($this->filter), function ($query) {
            $query->where(function ($query) {
                foreach ($this->filter as $field => $value) {
                    $query->when($field == 'global_search', function ($query) use ($value) {
                        $query->where(function ($query) use ($value) {
                            $query->where('id', $value)
                            ->orWhere('work_order_id', $value)
                            ->orWhereHas('workOrder', fn ($query) => $query->where('asset_id', $value));
                        });
                    })->when($field == 'work_order_id', function ($query) use ($value) {
                        $query->where('work_order_id', $value);
                    })->when($field == 'type', function ($query) use ($value) {
                        $query->where('type', 'like', '%' . $value . '%');
                    })->when($field == 'description', function ($query) use ($value) {
                        $query->where('description', 'like', '%' . $value . '%');
                    })->when($field == 'range_created_at', function ($query) use ($value) {
                        $range = parseRangeDate($value);
                        $query->whereBetween(DB::raw('DATE(created_at)'), [
                        $range['start_date'],
                        $range['end_date']
                        ]);
                    })->when($field == 'amount', function ($query) use ($value) {
                        $this->amountRange($query, $value);
                    })->when($field == 'location' && !empty($value), function ($query) use ($value) {
                        $query->WhereHas('workOrder', function ($q) use ($value) {
                            $q->whereHas('asset', function ($q) use ($value) {
                                $q->whereHas('location', fn ($q) => $q->where('name', 'like', "%$value%"));
                            });
                        });
                    })->when($field == 'assigned' && !empty($value), function ($query) use ($value) {
                        $query->whereHas('workOrder', fn ($q) => $q->where('assignee_user_id', $value));
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
        /** @phpstan-ignore-next-line */
        return view($this->viewFile, [
            'data' => $this->expenses()->paginate($this->perPage)
        ]);
    }

    /**
    *@param mixed $query
    *@param mixed $value
    *@return void
     */
    public function amountRange($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->when(isset($value['min']), function ($query) use ($value) {
                $query->where('amount', '>=', $value['min'] < $value['max']
                ? $value['min'] : $value['max']);
            });
            $query->when(isset($value['max']), function ($query) use ($value) {
                $query->where('amount', '<=', $value['max'] > $value['min']
                ? $value['max'] : $value['min']);
            })->orWhereNull('amount');
        });
    }

    public function delete(mixed $id): void
    {
        Expense::where('id', $id)->delete();

        $this->emit('closeModal');
    }

    public function edit(mixed $data): void
    {
        $data['amount'] =  isset($data['amount']) ? currency($data['amount']) : '';
        $data['expense_date'] = isset($data['expense_date']) ?
            customDateFormat($data['expense_date'], true, 'm-d-Y') : '';
        $this->dispatchBrowserEvent('edit-modal', $data);
    }
}
