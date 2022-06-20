<?php

namespace App\Traits;

use App\Models\DeleteLog;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasModel
{
    /**
     * create delete logs
     */
    protected static function createDeleteLogs(mixed $entity): void
    {
        $field = match (class_basename($entity)) {
            'Asset' => 'name',
            'AssetType' => 'name',
            'Company' => 'name',
            'WorkOrder' => 'title',
            default => 'full_name'
        };
        if (class_basename($entity) == 'Company') {
            $companyId = $entity->id;
        } else {
            $companyId = $entity->company_id;
        }

        DeleteLog::create([
            'user_id' => auth()->Id(),
            'company_id' => $companyId,
            'entity_type' => $entity::class,
            'entity_id' => $entity->id,
            'description' => $entity->{$field},
        ]);
    }

     /**
     * create formated id
     */
    protected static function updateFormatedId(mixed $entity): void
    {
        $entity->number = formatedId($entity->id);
        $entity->save();
    }
}
