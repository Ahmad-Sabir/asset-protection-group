<?php

namespace Database\Factories;

use App\Models\Admin\WorkOrder\AdditionalTask;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdditionalTaskFactory extends Factory
{
    /** @var mixed $model */
    protected $model = AdditionalTask::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $workOrder = WorkOrder::factory()->create();

        return  [
            "name" => $this->faker->name(),
            "task_detail" => $this->faker->title(),
            "due_date" => now()->format('Y-m-d'),
            "work_order_id" => $workOrder->id,
        ];
    }
}
