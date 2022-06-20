<?php

namespace App\Services\Admin\Company;

use App\Http\Requests\Company\ExpenseRequest;
use App\Models\Company;
use App\Events\CompanyCreated;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Admin\WorkOrder\WorkOrderLogs;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExpenseService
{
    public function __construct(
        protected Expense $expense,
        protected WorkOrderLogs $workOrderLogs,
    ) {
    }

    /**
     * store user
     *
     * @param ExpenseRequest $request
     * @return mixed
     */
    public function store(ExpenseRequest $request)
    {
        $data = $this->prepareData($request);

        return $this->expense->create($data);
    }

     /**
     * update expense
     *
     * @param ExpenseRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ExpenseRequest $request, $id)
    {
        $data = $this->prepareData($request);
        $updateExpense = $this->expense->find($id);
        /** @var mixed $updateExpense */
        return $updateExpense->update($data);
    }

    /**
     * prepare data
     *
     * @param ExpenseRequest $request
     * @return array
     */
    public function prepareData(ExpenseRequest $request)
    {
        $data = $request->validated();
        $data['expense_date'] = $data['expense_date']
         /** @phpstan-ignore-next-line */
        ? Carbon::createFromFormat('m-d-Y', $data['expense_date'])->format('Y-m-d') : null;

        return $data;
    }

    /**
     * get single records
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->expense->where('work_order_id', $id)->orderBy('id', 'DESC')->get();
    }

    /**
     * get total work order Expense
     *
     * @param int $workOrderId
     * @return mixed
     */
    public function totalExpense($workOrderId)
    {
        return $this->expense->where('work_order_id', $workOrderId)->sum('amount');
    }

    /**
     * get total asset Expense
     *
     * @param int $assetId
     * @return mixed
     */
    public function getTotalAssetExpense($assetId)
    {
         /** @phpstan-ignore-next-line */
        return $this->expense->whereHas('workOrder', fn ($q) => $q->whereHas('asset', fn ($q) =>
        $q->where('id', $assetId)))->sum('amount');
    }

     /**
     * create auto expense
     *
     * @param array $data
     * @return mixed
     */
    public function createAutoExpense($data)
    {
        /** @var mixed $data */
        $rate =  $data['per_hour_rate'] > 0 ? $data['per_hour_rate'] : 0;
        $total = 0;
        if (!empty($data['time'])) {
            /** @var int[] $timesplit */
            $timesplit = explode(':', $data['time']);
            $time = [];
            $time['h'] = $timesplit[0] ?? 00;
            $time['m'] = $timesplit[1] ?? 00;
            $time['s'] = $timesplit[2] ?? 00;
            $min = ($time['h'] * 60) + $time['m'] + ($time['s'] > 55 ? 1 : 0);
            $total = $rate * $min / 60;
        }
        $setNewExpense = [
            "work_order_id"     => $data['work_order_id'],
            "amount"            => $total,
            "expense_date"      => now(),
            "expense_log_time"  => $data['time'],
            "company_id"        => $data['company_id'] ?? null,
        ];
        $this->expense->insert($setNewExpense);
    }
}
