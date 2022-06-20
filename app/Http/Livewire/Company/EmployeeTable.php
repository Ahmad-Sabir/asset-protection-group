<?php

namespace App\Http\Livewire\Company;

use App\Models\User;
use App\Services\Admin\ExportService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class EmployeeTable extends Component
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
    protected $listeners = ['delete', 'csvExport'];

    /**
     * set filter
     * @var array
     */
    public $filter = [];

    /**
     * set pay range
     * @var array
     */
    public $payrate = [];

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
     * @var string
     */
    public $companyId = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var bool
     */
    public $sortAsc = false;

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
    public function filter()
    {
        $this->isFilter = true;
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
            'module' => config('apg.export_module.company_employees'),
            'fileName' => __('messages.export_filename.employees')
        ];
        app(ExportService::class)->export($this->employees()->get(), [], [], $this->filter, [], $type, $module);
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
        if ($this->companyId) {
            $minValue = User::where('company_id', $this->companyId)->min('per_hour_rate');
            $maxValue = User::where('company_id', $this->companyId)->max('per_hour_rate');
            $rate = ['min' => (int) $minValue, 'max' => (int) $maxValue];
            $this->payrate = $rate;
            $this->filter['payrate'] = $rate;
        }
    }

    /**
     * set clear params.
     *
     * @return void
     */
    public function clear()
    {
        $this->filter = [];
        $this->filter['payrate'] = $this->payrate;
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
    public function employees()
    {
        /** @phpstan-ignore-next-line */
        return User::with(['profile:id,url'])
            ->when(!empty($this->where), function ($query) {
                $query->Where($this->where);
            })->when($this->isFilter && !empty($this->filter), function ($query) {
                $query->where(function ($query) {
                    foreach ($this->filter as $field => $value) {
                        $value = !is_array($value) ? trim($value) : $value;
                        $this->prepareFilter($query, $field, $value);
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
            'data' => $this->employees()->paginate($this->perPage)
        ]);
    }

    /** @phpstan-ignore-next-line */
    public function prepareFilter($query, $field, $value): void
    {
        $query->when($field == 'global_search', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $q = app()->environment('testing') ?
                "first_name || ' ' || last_name like ?" : "concat(first_name, ' ', last_name) like ?";
                $query->where('id', $value)
                ->orWhereRaw($q, ['%' . $value . '%']);
            });
        })->when($field == 'role', function ($query) use ($value) {
            $query->where('role', 'like', '%' . $value . '%');
        })->when($field == 'range_created_at', function ($query) use ($value) {
            $range = parseRangeDate($value);
            $query->whereBetween(DB::raw('DATE(created_at)'), [$range['start_date'], $range['end_date']]);
        })->when($field == 'payrate', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $value['min'] = (int) $value['min'];
                $value['max'] = (int) $value['max'];
                $query->when(isset($value['min']), function ($query) use ($value) {
                    $query->where('per_hour_rate', '>=', $value['min'] < $value['max'] ? $value['min'] : $value['max']);
                });
                $query->when(isset($value['max']), function ($query) use ($value) {
                    $query->where('per_hour_rate', '<=', $value['max'] > $value['min'] ? $value['max'] : $value['min']);
                })->orWhereNull('per_hour_rate');
            });
        });
    }

    public function edit(mixed $data): void
    {
        if (isset($data['per_hour_rate'])) {
            $data['per_hour_rate'] = currency($data['per_hour_rate']);
        }
        $this->dispatchBrowserEvent('edit-modal', $data);
    }

    public function delete(mixed $id): void
    {
        if (auth()->id() == $id) {
            $this->emit('closeModal');

            return;
        }
        /** @var \App\Models\User $employee */
        $employee = User::find($id);
        $employee->delete();

        $this->emit('closeModal');
    }
}
