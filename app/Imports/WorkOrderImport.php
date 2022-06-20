<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\Asset\AssetType;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WorkOrderImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    protected array $rows = [];
    protected int|null $companyId = null;
    protected const RECURRING_STATUS = 'apg.recurring_status.recurring';

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        $string = "nullable|max:255";
        $required = "required|max:255";
        $companyRule = $this->companyId ? ",company_id,{$this->companyId}" : '';
        return [
            'work_order_title'                  => $required,
            'work_order_description'            => $string,
            'work_order_additional_information' => $string,
            'work_order_priority'               => $string,
            'asset_type'                        => $required . '|exists:asset_types,name' . $companyRule,
            'asset'                             => $required . '|exists:assets,name',
            'assigned_employee_email'           => 'nullable|email|exists:users,email',
            'work_order_type'                   => $string . '|in:'
            . config('apg.work_order_type_check.non_recurring') . ','
            . config('apg.work_order_type_check.recurring'),
            'work_order_frequency'              => "required_if:work_order_type," . config(self::RECURRING_STATUS),
            'due_date'                          => "required|date_format:m-d-Y",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'work_order_title'                  => 'Work Order Title',
            'work_order_description'            => 'Work Order Description',
            'work_order_additional_information' => 'Work Order Additional Information',
            'work_order_priority'               => 'Work Order Priority',
            'asset_type'                        => 'Asset Type',
            'asset'                             => 'Asset',
            'assigned_employee_email'           => 'Assigned Employee Email',
            'work_order_type'                   => 'Work Order Type',
            'work_order_frequency'              => 'Work Order Frequency',
            'due_date'                          => 'Due Date',
        ];
    }

    /**
     *
     * @param mixed $rows
     * @return mixed
     */
    public function collection($rows)
    {
        $count = 0;
        foreach ($rows as $row) {
            /** @var \App\Models\User $user */
            $user = request()->user();
            /** @var \App\Models\Admin\Asset\AssetType $assetType */
            $assetType = AssetType::where('name', $row['asset_type'])->first();
            /** @var \App\Models\Admin\Asset\Asset $asset */
            $asset = Asset::where('name', $row['asset'])->first();
            $row = $this->prepareLogics($row);
            $row['due_date'] = $row['work_order_type'] == config(self::RECURRING_STATUS)
            ? now() : $row['due_date'];
            $workOrder = WorkOrder::create([
                'title' => $row['work_order_title'],
                'company_id' => $this->companyId,
                'type' => $this->companyId ? config('apg.type.company') : config('apg.type.master'),
                'location_id' => $asset->location_id,
                'description' => $row['work_order_description'] ?? null,
                'additional_info' => $row['work_order_additional_information'] ?? null,
                'priority' => $row['work_order_priority'] ?? null,
                'asset_type_id' => $assetType->id,
                'asset_id' => $asset->id,
                'assignee_user_id' => $user->id,
                'work_order_type' => $row['work_order_type'] ?? null,
                'work_order_frequency' => in_array($row['work_order_frequency'], config('apg.frequency')) ?
                $row['work_order_frequency'] : null,
                'due_date' => $row['due_date'],
                'work_order_status' => config('apg.work_order_status.open'),
                'flag' => 'off',
            ]);
            if ($row['work_order_type'] == config(self::RECURRING_STATUS)) {
                $this->bulkStore($workOrder, $asset->warranty_expiry_date);
            }

            $count++;
        }
        $this->rows['success_rows'] = $count;
    }

    /**
     * bulk store WorkOrder.
     *
     * @param mixed $workOrder
     * @param string|null $warranty_expiry_date
     * @return mixed
     */
    public function bulkStore($workOrder, $warranty_expiry_date)
    {
        $replicate = getWorkOrderFrequencyDays(
            $workOrder->due_date,
            $warranty_expiry_date,
            $workOrder['work_order_frequency']
        );
        if ($replicate < 1) {
            return $workOrder;
        }
        for ($i = 0; $i < $replicate; $i++) {
            $workOrder['due_date'] = getWorkOrderFrequencyDate(
                $dueDate ?? now()->format('Y-m-d'),
                $workOrder['work_order_frequency']
            );
            $orderStore = $workOrder->replicate()->fill(['due_date' => $workOrder['due_date']]);
            $orderStore->save();
            $dueDate = $workOrder['due_date'];
        }

        return $workOrder;
    }

     /**
     * @param Failure $failures
     */

    public function onFailure(Failure ...$failures): void
    {
        $this->rows['failures'] = $failures;
    }

    public function prepareLogics(mixed $row): mixed
    {
        $row['due_date'] = isset($row['due_date']) && $row['due_date'] ?
         /** @phpstan-ignore-next-line */
        Carbon::createFromFormat('m-d-Y', $row['due_date'])->format('Y-m-d') : null;
        return $row;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setCompany(int|null $companyId): void
    {
        $this->companyId = $companyId;
    }
}
