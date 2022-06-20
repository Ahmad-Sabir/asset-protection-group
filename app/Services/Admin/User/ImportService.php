<?php

 namespace App\Services\Admin\User;

use App\Events\Imported;
use App\Http\Requests\Admin\User\ImportRequest;
 use App\Imports\UsersImport;
 use App\Imports\AssetImport;
 use App\Imports\WorkOrderImport;
 use Maatwebsite\Excel\Facades\Excel;
 use Maatwebsite\Excel\Validators\ValidationException;

class ImportService
{
    protected const SUBJECT = 'messages.import_email_subject';
    protected const SUCCESS = 'messages.import_success';
    protected const ERROR   = 'messages.import_error';
    /**
     * Write code on Method
     *
     * @return mixed
     */
    public function importUser(ImportRequest $request)
    {
        $import = new UsersImport();

        /** @phpstan-ignore-next-line */
        $import->import($request->file('file'));
        $data = $import->getRows();

        $data['subject'] = __(self::SUBJECT, ['title' => 'User']);
        event(new Imported($data));
        return $this->redirect($data, 'Users');
    }

    /**
     * import assets
     *
     * @param  ImportRequest $request
     * @param  int|null $companyId
     * @return mixed
     */
    public function importAssets(ImportRequest $request, $companyId = null)
    {
        $import = new AssetImport();
        $import->setCompany($companyId);
         /** @phpstan-ignore-next-line */
        $import->import($request->file('file'));
        $data = $import->getRows();
        $data['subject'] = __(self::SUBJECT, ['title' => 'Asset']);

        event(new Imported($data));

        return $this->redirect($data, 'Assets');
    }

    /**
     * import workorders
     *
     * @param  ImportRequest $request
     * @param  int|null $companyId
     * @return mixed
     */
    public function importWorkOrders(ImportRequest $request, $companyId = null)
    {
        $import = new WorkOrderImport();
        $import->setCompany($companyId);
        /** @phpstan-ignore-next-line */
        $import->import($request->file('file'));
        $data = $import->getRows();

        $data['subject'] = __(self::SUBJECT, ['title' => 'Work Order']);
        event(new Imported($data));

        return $this->redirect($data, 'Work Order');
    }

    /**
     * import workorders
     *
     * @param  array $data
     * @param  string $title
     * @return mixed
     */
    public function redirect($data, $title)
    {
        if (isset($data['success_rows']) && $data['success_rows'] > 0) {
            return back()->with('success', __(
                self::SUCCESS,
                [
                    'count' => $data['success_rows'],
                    'title' => $title
                ]
            ));
        }

        return back()->with('error', __(self::ERROR));
    }
}
