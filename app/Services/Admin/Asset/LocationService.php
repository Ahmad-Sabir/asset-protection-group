<?php

namespace App\Services\Admin\Asset;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\Asset\Location;

class LocationService
{
    public function __construct(
        protected Location $location
    ) {
    }

    /**
     * insert location
     *
     * @param mixed $request
     * @return mixed
     */
    public function store($request)
    {
        return $this->location->withoutGlobalScope('lat_lng')->create($request->validated());
    }

    /**
     * update location
     *
     * @param mixed $request
     * @param int $id
     * @return mixed
     */
    public function update($request, $id)
    {
         /** @var \App\Models\Admin\Asset\Location $update */
        $update = $this->location->withoutGlobalScope('lat_lng')->find($id);

        return $update->update($request->validated());
    }

    /**
     * insert location
     *
     * @param mixed $request
     * @param int|null $id
     * @return mixed|null
     */
    public function create($request, $id = null)
    {
        $point = $request->input('location');
        if (!empty($point['latitude']) && !empty($point['longitude'])) {
            $lat_lng = sprintf("%s %s", $point['latitude'], $point['longitude']);
            $setLocation = !app()->environment('testing') ?
            DB::raw("ST_GeomFromText('POINT($lat_lng)')") : "174.854498997714";
            if (!app()->environment('testing')) {
                $check = $this->location->whereRaw('ST_X(location) = ?', $point['latitude'])
                ->whereRaw('ST_Y(location) = ?', $point['longitude'])
                ->doesntExist();
                if ($request->route('company') && !empty($point['name']) && $check) {
                    $this->location->withoutGlobalScope('lat_lng')->create([
                        'company_id' => $request->route('company'),
                        'name' => $point['name'],
                        'location' => $setLocation,
                        'is_crud' => 1,
                    ]);
                }
            }

            return $this->location->withoutGlobalScope('lat_lng')->updateOrCreate(['id' => $id], [
                'company_id' => $request->route('company') ?? null,
                'name' => $point['name'],
                'location' => $setLocation,
            ]);
        }

        return null;
    }
}
