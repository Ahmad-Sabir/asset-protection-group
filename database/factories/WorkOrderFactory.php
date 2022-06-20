<?php

namespace Database\Factories;

use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WorkOrderFactory extends Factory
{
    /** @var mixed $model */
    protected $model = WorkOrder::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $assettype = AssetType::factory()->create();
        $asset = Asset::factory()->create();
        $location = Location::factory()->create();
        $company = Company::factory()->create();
        $user = User::factory()->create();

        return  [
            "work_order_profile_id" => null,
            "title" => "cc",
            "description" => "cc",
            "priority" => "Low",
            "asset_type_id" =>  $assettype->id,
            "asset_id" => $asset->id,
            "location_id" => $location->id,
            "assignee_user_id" =>  $user->id,
            "work_order_type" => config('apg.recurring_status.non-recurring'),
            "additional_info" => null,
            "due_date" => now()->addDay()->format('Y-m-d'),
            "work_order_status" => config('apg.work_order_status.open'),
            "company_id" => $company->id,
            "type" => config('apg.type.company'),
        ];
    }
}
