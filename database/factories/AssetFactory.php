<?php

namespace Database\Factories;

use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset\Asset>
 */
class AssetFactory extends Factory
{
    /** @var mixed $model */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $location = Location::factory()->create();
        return [
            'name' => $this->faker->name(),
            'location_id' => $location->id,
        ];
    }
}
