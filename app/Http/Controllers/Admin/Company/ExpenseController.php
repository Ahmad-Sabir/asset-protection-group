<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\Company\CompanyService;
use App\Http\Requests\Company\ExpenseRequest;
use App\Http\Responses\BaseResponse;
use App\Models\Admin\Asset\Asset;
use App\Services\Admin\Company\ExpenseService;
use App\Models\Admin\WorkOrder\WorkOrder;

class ExpenseController extends Controller
{
    protected const CREATE_MESSAGE = 'messages.create';

    public function __construct(
        protected ExpenseService $expenseService,
        protected CompanyService $companyService,
    ) {
    }
    /**
     * Display a listing of the resource.
     * @param mixed $companyId
     * @return \Illuminate\View\View
     */
    public function index($companyId)
    {
        $company = app(CompanyService::class)->find($companyId);

        return view('admin.company.expense.index', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpenseRequest $request
     * @param  int $companyId
     * @return mixed
     */
    public function store(ExpenseRequest $request, $companyId)
    {
        return $this->customStore($request);
    }

    /**
       * Store a newly created resource in storage.
       *
       * @param  ExpenseRequest $request
       * @return mixed
       */
    public function masterExpense(ExpenseRequest $request)
    {
        return $this->customStore($request);
    }

    /**
       * Store a newly created resource in storage.
       *
       * @param  ExpenseRequest $request
       * @return BaseResponse
       */
    public function customStore(ExpenseRequest $request)
    {
          $this->expenseService->store($request);

          return new BaseResponse(
              STATUS_CODE_CREATE,
              __(self::CREATE_MESSAGE, ['title' => 'Expense']),
              []
          );
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  ExpenseRequest $request
     * @param  int  $expenseId
     * @param  int  $companyId
     * @return BaseResponse
     */
    public function update(ExpenseRequest $request, $companyId, $expenseId)
    {
        $this->expenseService->update($request, $expenseId);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Expense']),
            []
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpenseRequest $request
     * @return BaseResponse
     */
    public function employeeExpense(ExpenseRequest $request)
    {
        $this->expenseService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Expense']),
            []
        );
    }
}
