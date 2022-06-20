<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Models\Admin\Asset\AssetType;
use App\Services\Admin\Asset\AssetService;
use App\Http\Requests\Admin\Asset\AssetRequest;
use App\Http\Requests\Admin\User\ImportRequest;
use App\Models\Admin\Asset\Asset;
use App\Services\Admin\Company\CompanyService;
use App\Services\Admin\User\ImportService;
use App\Services\Admin\ExportService;

class AssetController extends Controller
{
    public function __construct(
        protected AssetService $assetService,
        protected AssetType $assetType,
        protected ExportService $exportService,
        protected CompanyService $companyService,
    ) {
    }

    /**
     * Display a listing of the resource.
     * @param int $companyId
     * @return \Illuminate\View\View
     */
    public function index($companyId)
    {
        $company = $this->companyService->find($companyId);

        return view('admin.company.asset.index', compact('company'));
    }

    /**
     * Display a listing of the resource.
     * @param int $companyId
     * @return \Illuminate\View\View
     */
    public function create($companyId)
    {
        $asset = '';
        $company = $this->companyService->find($companyId);
        if (request('master_asset_id')) {
            $asset = $this->assetService->find(request('master_asset_id'));
        }

        return view('admin.company.asset.create', compact('company', 'asset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssetRequest $request
     * @param  int $companyId
     * @return BaseResponse
     */
    public function store(AssetRequest $request, $companyId)
    {
        $this->assetService->store($request, true);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Asset']),
            ['redirect_url' => route('admin.companies.assets.index', $companyId)]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $companyId
     * @param  int $assetId
     * @return \Illuminate\View\View
     */
    public function show($companyId, $assetId)
    {
        $asset = $this->assetService->find($assetId, true);
        $company = $this->companyService->find($companyId);
        $totalExpense = app(\App\Services\Admin\Company\ExpenseService::class)->getTotalAssetExpense($assetId);

        return view('admin.company.asset.show', compact('asset', 'company', 'totalExpense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $companyId
     * @param  int $assetId
     * @return \Illuminate\View\View
     */
    public function edit($companyId, $assetId)
    {
        $company = $this->companyService->find($companyId);
        $asset = $this->assetService->find($assetId);

        return view('admin.company.asset.edit', compact('asset', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AssetRequest $request
     * @param  int  $companyId
     * @param  int  $assetId
     * @return BaseResponse
     */
    public function update(AssetRequest $request, $companyId, $assetId)
    {
        $this->assetService->update($request, $assetId);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Asset']),
            ['redirect_url' => route('admin.companies.assets.index', $companyId)]
        );
    }

    /**
     * import assets
     *
     * @param  ImportRequest $request
     * @param  int $companyId
     * @return mixed
     */
    public function importCsv(ImportRequest $request, $companyId)
    {
        return (new ImportService())->importAssets($request, $companyId);
    }

     /**
     * Send attachments via email.
     *
     * @param string $id
     * @param string $companyId
     * @return mixed
     */
    public function exportCompanyAssetPdf($companyId, $id = '')
    {
        $assets = $this->assetService->exportCompanyAssetPdf($companyId, $id);
        $pdfTemplate = config('apg.pdf_options.template.asset-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        $filter = [];
        $file = $assets[0]->name ?? '';
        $modules = [
            'fileName' => __('messages.export_filename.asset', ['name' => $file]),
            'isLocation' => true,
            'emailView' => 'email-template.exports.company-asset-single'
        ];
        return $this->exportService->export(
            $assets,
            $pdfTemplate,
            $orientation,
            $filter,
            [],
            config('apg.export_format.pdf'),
            $modules
        );
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $companyId
     * @return mixed
     */
    public function companyAssetCompliancePdf($companyId, $assetId)
    {
        $data['module'] = 'asset_company_compliance';
        $data['fileName'] = __('messages.export_filename.company_asset_compliance');
        $data['pdf'] = 'asset-comprehensive-print';
        $data['orientation'] = 'landscape';
        $data['companyId'] = $companyId;
        $data['assetId'] = $assetId;
        $data['emailView'] = 'email-template.exports.compliance';
        return $this->companyCompliancePlan($data);
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $companyId
     * @return mixed
     */
    public function companyGridCompliancePdf($companyId, $assetId)
    {
        $data['module'] = 'asset_grid_compliance';
        $data['fileName'] = __('messages.export_filename.asset_grid_compliance');
        $data['pdf'] = 'asset-compliance-print';
        $data['orientation'] = 'landscape';
        $data['companyId'] = $companyId;
        $data['assetId'] = $assetId;
        return $this->companyCompliancePlan($data);
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $companyId
     * @return mixed
     */
    public function companyDetailCompliancePdf($companyId, $assetId)
    {
        $data['module'] = 'asset_detail_compliance';
        $data['fileName'] = __('messages.export_filename.asset_detail_compliance');
        $data['pdf'] = 'work-order-print';
        $data['orientation'] = 'portrait';
        $data['assetId'] = $assetId;
        $data['companyId'] = $companyId;
        return $this->companyCompliancePlan($data);
    }

    /**
     * companyCompliancePlan.
     *
     * @param mixed $data
     * @return mixed
     */
    public function companyCompliancePlan($data)
    {
        return app(\App\Services\Admin\ExportService::class)->export(
            [],
            $data['pdf'],
            $data['orientation'],
            [],
            '',
            config('apg.export_format.pdf'),
            [
                'module' => $data['module'],
                'fileName' => $data['fileName'],
                'params' => [
                    'id' => $data['assetId'],
                    'companyId' => $data['companyId']
                ],
                'emailView' => $data['emailView'] ?? ''
            ]
        );
    }
}
