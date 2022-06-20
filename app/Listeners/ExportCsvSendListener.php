<?php

namespace App\Listeners;

use App\Events\Export;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ExportCsvSendListener implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * columnNames
     *
     * @var array
     */
    protected $columnNames = [
        'asset_id' => 'Asset ID',
        'company_id' => 'Company ID',
        'name' => 'Name',
        'asset_type' => 'Asset Type',
        'status' => 'Status',
        'id' => 'ID',
        'work_order' => 'Work Order',
        'asset' => 'Asset',
        'assigned_to' => 'Assigned To',
        'last_updated' => 'Last Updated',
        'title' => 'Title',
        'due_to' => 'Due Date',
        'location' => 'Location',
        'work_order_type' => 'Work Order Type',
        'work_order_freq' => 'Work Order Freq',
        'notes' => 'Notes',
        'pay_rates' => 'Pay Rates',
        'location_id' => 'Location Id',
        'created_at' => 'Created At',
        'manufacturer' => 'Manufacturer',
        'model' => 'Model',
        'replacement_cost' => 'Replacement Cost',
        'purchase_price' => 'Purchase Price',
        'remaining_useful_life' => 'Remaining Useful Life',
        'total_useful_life' => 'Total Useful Life',
        'warranty_expiry_date' => 'Warranty Expiry Date',
        'asset_type_id' => 'Asset Type Id',
        'assignee_user_id' => 'Assignee User Id',
        'work_order_status' => 'Work Order Status',
        'updated_at' => 'Updated At',
        'manager_email' => 'Manager Email',
        'company_manager_name' => 'Company Manager Name',
        'deactivate_at' => 'Deactivate At',
        'due_date' => 'Due Date',
        'purchase_date' => 'Purchase Date',
        'installation_date' => 'Installation Date',
        'total_useful_life_date' => 'Total Useful Life Date',
        'company_number' => 'Company Number',
        'remaining_warranty' => 'Remaining Warranty',
        'additional_information' => 'Additional Information',
        'expense' =>
        [
            'description'    => 'Description',
            'type'           => 'Type',
            'amount'         => 'Amount',
            'expense_date'   => 'Expense Date',
            'work_order_id'  => 'Work Order ID',
            'employee_name'  => 'Employee Name',
        ]
    ];

    /**
     * format
     *
     * @var mixed
     */
    protected $format = '';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->format = config('apg.export_format.csv');
    }

    /**
     * Handle the event.
     *
     * @param  Export $data
     * @return void
     */
    public function handle(Export $data)
    {
        if (property_exists($data, 'module') && Arr::has($data->module, 'isLocation')) {
            $data->data->loadMissing(['location' => fn ($q) => $q->select('*')]);
        }
        if ($data->type == $this->format) {
            switch ($data->module['module']) {
                case config('apg.export_module.master_asset'):
                    $attachment = $this->getMasterAssetCsv($data->data, $data->module['assetType']);
                    break;
                case config('apg.export_module.master_workorder'):
                    $attachment = $this->getMasterWorkOrderCsv($data->data);
                    break;
                case config('apg.export_module.asset_workorder_single'):
                    $attachment = $this->getMasterWorkOrderSingleCsv($data->data);
                    break;
                case config('apg.export_module.company_employees'):
                    $attachment = $this->getCompanyEmployeesCsv($data->data);
                    break;
                case config('apg.export_module.report_asset'):
                    $attachment = $this->getReportAssetCsv($data->fields, $data->data);
                    break;
                case config('apg.export_module.report_workorder'):
                    $attachment = $this->getReportWorkOrderCsv($data->fields, $data->data);
                    break;
                case config('apg.export_module.report_company'):
                    $attachment = $this->getReportCompanyCsv($data->fields, $data->data);
                    break;
                case config('apg.export_module.expense'):
                    $data->data->loadMissing(['workOrder.asset.location' => fn ($q) => $q->select('*')]);
                    $attachment = $this->getExpenseCsv($data->data);
                    break;
                default:
                    $attachment = [];
                    break;
            }
            $emailView = (!empty($data->module['emailView']))
                ? $data->module['emailView']
                : 'email-template.attached-pdf-email';
            $body = view($emailView, ['data' => $data])->render();
            send_mail(
                $data->module['toEmail'],
                "Welcome to " . config('app.name') . " ",
                $body,
                '',
                $attachment,
                $data->type ?? '',
                $data->module['fileName'] ?? ''
            );
        }
    }

    /**
     * master asset csv output
     *
     * @param mixed $data
     * @param mixed $assetType
     * @return mixed
     */
    public function getMasterAssetCsv($data, $assetType = '')
    {
        $fileContent = function () use ($data, $assetType) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = [
                $this->columnNames['asset_id'],
                $this->columnNames['company_id'],
                $this->columnNames['name'],
                $this->columnNames['asset_type'],
                $this->columnNames['model'],
                $this->columnNames['manufacturer'],
                $this->columnNames['status'],
                $this->columnNames['location'],
                $this->columnNames['purchase_date'],
                $this->columnNames['remaining_useful_life'],
                $this->columnNames['warranty_expiry_date'],
                $this->columnNames['remaining_warranty'],
                $this->columnNames['installation_date'],
                $this->columnNames['total_useful_life'],
                $this->columnNames['additional_information'],
                $this->columnNames['replacement_cost'],
                $this->columnNames['purchase_price'],
            ];
            if ($assetType == config('apg.type.master')) {
                unset($columns[1]);
            }
            if ($file) {
                fputcsv($file, $columns);
                $assets = $data;

                foreach ($assets as $asset) {
                    $row[$this->columnNames['asset_id']] = $asset->number;
                    $row[$this->columnNames['company_id']] = $asset->company_number;
                    $row[$this->columnNames['name']] = $asset->name;
                    $row[$this->columnNames['asset_type']] = $asset->assetType?->name;
                    $row[$this->columnNames['model']] = $asset->model;
                    $row[$this->columnNames['manufacturer']] = $asset->manufacturer;
                    $row[$this->columnNames['status']] = ($asset->status) ? 'Active' : 'In Active';
                    $row[$this->columnNames['location']] = $asset->location?->name;
                    $row[$this->columnNames['purchase_date']] = $asset->purchase_date ?
                        customDateFormat($asset->purchase_date) : '';
                    $row[$this->columnNames['remaining_useful_life']] = !empty($asset->total_useful_life_date) ?
                        remainingDays($asset->total_useful_life_date) : '';
                    $row[$this->columnNames['warranty_expiry_date']] =  $asset->warranty_expiry_date ?
                        customDateFormat($asset->warranty_expiry_date) : '';
                    $row[$this->columnNames['remaining_warranty']] = remainingWarrantyDays(
                        $asset->installation_date,
                        $asset->warranty_expiry_date
                    );
                    $row[$this->columnNames['installation_date']] = customDateFormat($asset->installation_date);
                    $row[$this->columnNames['total_useful_life']] = !empty($asset->total_useful_life)
                        ? totalUseFulLife($asset->total_useful_life)
                        : '';
                    $row[$this->columnNames['additional_information']] = $asset->description;
                    $row[$this->columnNames['replacement_cost']] = currency($asset->replacement_cost);
                    $row[$this->columnNames['purchase_price']] = currency($asset->purchase_price);
                    if ($assetType == config('apg.type.master')) {
                        unset($row[$this->columnNames['company_id']]);
                    }
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * master workorder csv output
     *
     * @param mixed $data
     * @return mixed
     */
    public function getMasterWorkOrderCsv($data)
    {
        $fileContent = function () use ($data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = [
                $this->columnNames['id'],
                $this->columnNames['work_order'],
                $this->columnNames['asset'],
                $this->columnNames['asset_type'],
                $this->columnNames['assigned_to'],
                $this->columnNames['status'],
                $this->columnNames['last_updated'],
                $this->columnNames['work_order_type']
            ];
            if ($file) {
                fputcsv($file, $columns);
                $workOrders = $data;

                foreach ($workOrders as $workOrder) {
                    $row[$this->columnNames['id']] = $workOrder->id;
                    $row[$this->columnNames['work_order']] = $workOrder->title;
                    $row[$this->columnNames['asset']] = $workOrder->asset?->name;
                    $row[$this->columnNames['asset_type']] = $workOrder->assetType?->name;
                    $row[$this->columnNames['assigned_to']] = $workOrder->user?->fullname;
                    $row[$this->columnNames['status']] = $workOrder->work_order_status;
                    $row[$this->columnNames['last_updated']] = customDateFormat($workOrder->updated_at);
                    $row[$this->columnNames['work_order_type']] = $workOrder->type;
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * master workorder single csv output
     *
     * @param mixed $data
     * @return mixed
     */
    public function getMasterWorkOrderSingleCsv($data)
    {
        $fileContent = function () use ($data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = [
                $this->columnNames['id'],
                $this->columnNames['title'],
                $this->columnNames['asset'],
                $this->columnNames['asset_type'],
                $this->columnNames['assigned_to'],
                $this->columnNames['due_to'],
                $this->columnNames['last_updated'],
                $this->columnNames['location'],
                $this->columnNames['work_order_type'],
                $this->columnNames['work_order_freq'],
                $this->columnNames['notes'],
            ];
            if ($file) {
                fputcsv($file, $columns);
                $workOrders = $data;

                foreach ($workOrders as $workOrder) {
                    $dueDate = $workOrder->due_date ?? '';
                    $updatedAt = $workOrder->updated_at ?? '';
                    $row[$this->columnNames['id']] = $workOrder->id;
                    $row[$this->columnNames['title']] = $workOrder->title;
                    $row[$this->columnNames['asset']] = $workOrder->asset?->name;
                    $row[$this->columnNames['asset_type']] = $workOrder->assetType?->name;
                    $row[$this->columnNames['assigned_to']] = $workOrder->user?->full_name;
                    $row[$this->columnNames['due_to']] = customDateFormat($dueDate);
                    $row[$this->columnNames['last_updated']] = customDateFormat($updatedAt);
                    $row[$this->columnNames['location']] = $workOrder->location?->name;
                    $row[$this->columnNames['work_order_type']] = $workOrder->work_order_type;
                    $row[$this->columnNames['work_order_freq']] = $workOrder->work_order_frequency;
                    $row[$this->columnNames['notes']] = $workOrder->additional_info;
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * company employees csv output
     *
     * @param mixed $data
     * @return mixed
     */
    public function getCompanyEmployeesCsv($data)
    {
        $fileContent = function () use ($data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = [
                $this->columnNames['id'],
                $this->columnNames['name'],
                $this->columnNames['pay_rates'],
                $this->columnNames['status']
            ];
            if ($file) {
                fputcsv($file, $columns);
                $employees = $data;

                foreach ($employees as $employee) {
                    $row[$this->columnNames['id']] = $employee->id;
                    $row[$this->columnNames['name']] = $employee->first_name . '' . $employee->last_name;
                    $row[$this->columnNames['pay_rates']] = !is_null($employee->per_hour_rate)
                        ? currency($employee->per_hour_rate) . '/hr'
                        : '';
                    $row[$this->columnNames['status']] = is_null($employee->deactivate_at) ? 'Active' : 'Inactive';
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * get columns
     *
     * @param array $fields
     * @return array
     */
    public function getColumns($fields)
    {
        $columns = [];
        unset($fields['created_at']);
        foreach ($fields as $key => $column) {
            if ($fields[$key] || $column) {
                $columns[] = Str::title(Str::replace('_', ' ', $key));
            }
        }
        return $columns;
    }

    /**
     * report asset csv output
     *
     * @param array $fields
     * @param array $data
     * @return mixed
     */
    public function getReportAssetCsv($fields, $data)
    {
        $fileContent = function () use ($fields, $data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = $this->getColumns($fields);
            if ($file) {
                fputcsv($file, $columns);
                $assetReports = $data;
                $row = [];
                foreach ($assetReports as $asset) {
                    if ($fields['id']) {
                        $row[$this->columnNames['id']] = $asset->id;
                    }
                    if ($fields['company_id']) {
                        $row[$this->columnNames['company_id']] = $asset->company->id;
                    }
                    if ($fields['installation_date']) {
                        $row[$this->columnNames['installation_date']] = $asset->installation_date
                        ? customDateFormat($asset->installation_date) : '';
                    }
                    if ($fields['name']) {
                        $row[$this->columnNames['name']] = $asset->name;
                    }
                    if ($fields['asset_type']) {
                        $row[$this->columnNames['asset_type']] = $asset->assetType?->name;
                    }
                    if ($fields['status']) {
                        $row[$this->columnNames['status']] = $asset->status ? 'Active' : 'Inactive';
                    }
                    if ($fields['location_id']) {
                        $row[$this->columnNames['location_id']] = $asset->location?->name;
                    }
                    if ($fields['manufacturer']) {
                        $row[$this->columnNames['manufacturer']] = $asset->manufacturer;
                    }
                    if ($fields['model']) {
                        $row[$this->columnNames['model']] = $asset->model;
                    }
                    if ($fields['replacement_cost']) {
                        $row[$this->columnNames['replacement_cost']] = currency($asset->replacement_cost);
                    }
                    if ($fields['purchase_price']) {
                        $row[$this->columnNames['purchase_price']] = currency($asset->purchase_price);
                    }
                    if ($fields['remaining_useful_life']) {
                        $row[$this->columnNames['remaining_useful_life']] = !empty($asset->total_useful_life_date)
                        ? remainingDays($asset->total_useful_life_date) : '';
                    }
                    if ($fields['total_useful_life']) {
                        $row[$this->columnNames['total_useful_life']] = !empty($asset->total_useful_life)
                        ? totalUseFulLife($asset->total_useful_life) : '';
                    }
                    if ($fields['warranty_expiry_date']) {
                        $row[$this->columnNames['warranty_expiry_date']] = remainingWarrantyDays(
                            $asset->installation_date,
                            $asset->warranty_expiry_date
                        );
                    }
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * report workorder csv output
     *
     * @param array $fields
     * @param array $data
     * @return mixed
     */
    public function getReportWorkOrderCsv($fields, $data)
    {
        $fileContent = function () use ($fields, $data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = $this->getColumns($fields);
            if ($file) {
                fputcsv($file, $columns);
                $workOrderReports = $data;
                $row = [];
                foreach ($workOrderReports as $workOrder) {
                    if ($fields['id']) {
                        $row[$this->columnNames['id']] = $workOrder->id;
                    }
                    if ($fields['title']) {
                        $row[$this->columnNames['title']] = $workOrder->title;
                    }
                    if ($fields['asset_id']) {
                        $row[$this->columnNames['asset_id']] = $workOrder->asset?->name;
                    }
                    if ($fields['asset_type_id']) {
                        $row[$this->columnNames['asset_type_id']] = $workOrder->assetType?->name;
                    }
                    if ($fields['assignee_user_id']) {
                        $row[$this->columnNames['assignee_user_id']] = $workOrder->user?->full_name;
                    }
                    if ($fields['work_order_status']) {
                        $row[$this->columnNames['work_order_status']] = $workOrder->work_order_status;
                    }
                    if ($fields['due_date']) {
                        $row[$this->columnNames['due_date']] = customDateFormat($workOrder->due_date);
                    }
                    if ($fields['work_order_type']) {
                        $row[$this->columnNames['work_order_type']] = $workOrder->work_order_type;
                    }
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }

    /**
     * report company csv output
     *
     * @param array $fields
     * @param array $data
     * @return mixed
     */
    public function getReportCompanyCsv($fields, $data)
    {
        $fileContent = function () use ($fields, $data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns = $this->getColumns($fields);
            if ($file) {
                fputcsv($file, $columns);
                $companies = $data;
                $row = [];
                foreach ($companies as $company) {
                    if ($fields['id']) {
                        $row[$this->columnNames['id']] = $company->id;
                    }
                    if ($fields['name']) {
                        $row[$this->columnNames['name']] = $company->name;
                    }
                    if ($fields['manager_email']) {
                        $row[$this->columnNames['manager_email']] = $company->manager_email;
                    }
                    if ($fields['company_manager_name']) {
                        $row[$this->columnNames['company_manager_name']] = $company->fullName;
                    }
                    if ($fields['deactivate_at']) {
                        $row[$this->columnNames['deactivate_at']] = is_null($company->deactivate_at)
                        ? 'Active' : 'Inactive';
                    }
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }
      /**
     *  expense csv
     * @param array $data
     * @return mixed
     */
    public function getExpenseCsv($data)
    {
        $fileContent = function () use ($data) {
            $fileName = Str::random(15) . '.' . $this->format;
            $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
            $file = fopen($filePath, 'w');
            $columns =
            [
                $this->columnNames['id'],
                $this->columnNames['expense']['expense_date'],
                $this->columnNames['expense']['type'],
                $this->columnNames['expense']['description'],
                $this->columnNames['expense']['amount'],
                $this->columnNames['expense']['work_order_id'],
                $this->columnNames['asset_id'],
                $this->columnNames['expense']['employee_name'],
                $this->columnNames['location']
            ];
            if ($file) {
                fputcsv($file, $columns);
                $expenses = $data;
                foreach ($expenses as $expense) {
                    $row[$this->columnNames['id']] = $expense->id;
                    $row[$this->columnNames['expense']['expense_date']] = customDateFormat($expense->expense_date);
                    $row[$this->columnNames['expense']['type']] = $expense->type;
                    $row[$this->columnNames['expense']['description']] = $expense->description;
                    $row[$this->columnNames['expense']['amount']] = currency($expense->amount);
                    $row[$this->columnNames['expense']['work_order_id']] =  $expense->workOrder?->number;
                    $row[$this->columnNames['asset_id']] =  $expense->workOrder?->asset?->number;
                    $row[$this->columnNames['expense']['employee_name']] = $expense->workOrder?->user?->full_name;
                    $row[$this->columnNames['location']] = $expense->workOrder?->asset?->location?->name;
                    fputcsv($file, $row);
                }
                fclose($file);
            }

            return file_get_contents($filePath);
        };

        return $fileContent();
    }
}
