<?php

namespace App\Http\Controllers\Admin\Asset;

use Illuminate\Http\Request;
use App\Models\Admin\Asset\Asset;
use App\Exports\AssetSampleExport;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\Asset\AssetType;
use App\Services\Admin\Asset\AssetService;
use App\Http\Requests\Admin\Asset\AssetRequest;
use App\Http\Requests\Admin\User\ImportRequest;
use App\Services\Admin\User\ImportService;
use App\Services\Admin\ExportService;

class AssetController extends Controller
{
    protected const CREATE_MESSAGE = 'messages.create';
    public function __construct(
        protected AssetService $assetService,
        protected AssetType $assetType,
        protected ExportService $exportService,
        protected Asset $asset,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.asset.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function companyAssets()
    {
        return view('admin.asset.company-assets');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.asset.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssetRequest $request
     * @return BaseResponse
     */
    public function store(AssetRequest $request)
    {
        $this->assetService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Asset']),
            ['redirect_url' => route('admin.assets.index')]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $asset = $this->assetService->find($id, true);
        $totalExpense = app(\App\Services\Admin\Company\ExpenseService::class)->getTotalAssetExpense($id);

        return view('admin.asset.show', compact('asset', 'totalExpense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $asset = $this->assetService->find($id);

        return view('admin.asset.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AssetRequest $request
     * @param  int  $id
     * @return BaseResponse
     */
    public function update(AssetRequest $request, $id)
    {
        $this->assetService->update($request, $id);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Asset']),
            ['redirect_url' => route('admin.assets.index')]
        );
    }

    /**
     * get export template
     *
     * @return mixed
     */
    public function exportTemplate()
    {
        return Excel::download(new AssetSampleExport(), 'asset-template.csv');
    }

    /**
     * import assets
     *
     * @param  ImportRequest $request
     * @return mixed
     */
    public function importCsv(ImportRequest $request)
    {
        return (new ImportService())->importAssets($request);
    }

    /**
     * import assets
     *
     * @param  Request $request
     * @param  int $assetId
     * @return mixed
     */
    public function uploadMedia(Request $request, $assetId)
    {
        $this->assetService->uploadMedia($request, $assetId);

        return back()->with(['success' =>  __('messages.media_upload'), 'is_upload_media' => true]);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportAssetPdf($id = '')
    {
        $assets = $this->assetService->exportAssetPdf($id);
        $fileName = (!empty($assets)) ? $assets[0]['name'] : '';
        $pdfTemplate = config('apg.pdf_options.template.asset-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        $filter = [];

        return $this->exportService->export(
            $assets,
            $pdfTemplate,
            $orientation,
            $filter,
            [],
            config('apg.export_format.pdf'),
            [
                'fileName' => __('messages.export_filename.asset', ['name' => $fileName]),
                'isLocation' => true,
                'emailView' => 'email-template.exports.master-asset-single'
            ]
        );
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $assetTypeId
     * @return mixed
     */
    public function exportAssetCompliancePdf($assetId, $assetTypeId)
    {
        $data['module'] = 'asset_compliance';
        $data['fileName'] = __('messages.export_filename.asset_compliance');
        $data['pdf'] = 'asset-comprehensive-print';
        $data['orientation'] = 'landscape';
        $data['id'] = $assetId;
        $data['emailView'] = 'email-template.exports.compliance';
        return $this->compliancePlan($data);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportAssetGridCompliancePdf($id)
    {
        $data['module'] = 'asset_grid_compliance';
        $data['fileName'] = __('messages.export_filename.asset_grid_compliance');
        $data['pdf'] = 'asset-compliance-print';
        $data['orientation'] = 'landscape';
        $data['id'] = $id;
        return $this->compliancePlan($data);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportAssetDetailCompliancePdf($id)
    {
        $data['module'] = 'asset_detail_compliance';
        $data['fileName'] = __('messages.export_filename.asset_detail_compliance');
        $data['pdf'] = 'work-order-print';
        $data['orientation'] = 'portrait';
        $data['id'] = $id;
        return $this->compliancePlan($data);
    }

    /**
     * Send attachments via email.
     *
     * @param mixed $data
     * @return mixed
     */
    public function compliancePlan($data)
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
                    'id' => $data['id']
                ],
                'emailView' => $data['emailView'] ?? ''
            ]
        );
    }
}
