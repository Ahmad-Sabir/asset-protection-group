<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DeleteLog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class DeleteLogTable extends Component
{
    use WithPagination;

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * set filter
     * @var array
     */
    public $filter = [];

    /**
     * @var bool
     */
    public $selectAll = false;

    /**
     * set filter
     * @var array
     */
    public $logIds = [];

    /**
     * set logs data
     * @var mixed
     */
    protected $logs = [];

    /**
     * set search
     * @var string
     */
    public $search = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public $sortField = 'id';

    /**
     * Listeners for component
     * @var array
     */
    protected $listeners = ['delete', 'reStore', 'bulkRestore'];

    /**
     * Livewire Lifecycle Hook
     *
     * @param bool $value
     * @return void
     */
    public function dehydrateSelectAll($value)
    {
        $this->logIds = $value ? $this->logs->pluck('id')->toArray() : [];
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
    public function filter()
    {
      //
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
     * set restore entity.
     *
     * @param int $logId
     * @param bool $deleteEntity
     * @return void
     */
    public function reStore($logId, $deleteEntity = false)
    {
        /** @var \App\Models\DeleteLog $deleteLog */
        $deleteLog = DeleteLog::find($logId);
        $entity = $deleteLog->entity()->withTrashed()->first();
        if ($deleteEntity) {
            $entity?->forcedelete();
        } else {
            $entity?->restore();
        }
        $deleteLog->delete();
    }

    /**
     * bulk restore entity.
     *
     * @param bool $deleteEntity
     * @return void
     */
    public function bulkRestore($deleteEntity = false)
    {
        DeleteLog::whereIn('id', $this->logIds)->get()->each(function ($log) use ($deleteEntity) {
            $this->reStore($log->id, $deleteEntity);
        });
    }

    /**
     * delete log.
     *
     * @param int $logId
     * @return void
     */
    public function delete($logId)
    {
        $this->reStore($logId, true);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        /** @phpstan-ignore-next-line */
        $this->logs = DeleteLog::with([
            'user',
            'entity',
            'company:id,name'
        ])->when(!empty($this->filter), function ($query) {
            foreach ($this->filter as $field => $value) {
                $this->search = trim($value);
                $query->when(!empty($value) && $field == 'user_name', function ($query) {
                    /** @phpstan-ignore-next-line */
                    $query->whereHas('user', function ($query) {
                        $q = app()->environment('testing') ?
                        "first_name || ' ' || last_name like ?" : "concat(first_name, ' ', last_name) like ?";
                        $query->whereRaw($q, ['%' . $this->search . '%']);
                    });
                })->when(!empty($value) && $field == 'company', function ($query) {
                    $query->whereHas('company', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                })->when(!empty($value) && $field == 'description', function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%');
                })->when($field == 'range_created_at', function ($query) use ($value) {
                    $range = parseRangeDate($value);
                    $query->whereBetween(DB::raw('DATE(created_at)'), [$range['start_date'], $range['end_date']]);
                });
            }
        })->orderBy('id', 'desc')
        ->paginate($this->perPage);

        return view('admin.delete-logs.table', [
            'logs' => $this->logs
        ]);
    }
}
