<?php

namespace App\Utils;

use App\Models\Orderable;
use Illuminate\Support\Collection;

class EntityOrderUtil
{
    /**
     * @param  array  $entities
     * @param  string  $orderable
     * @return mixed
     */
    public function reorderEntities(array $entities, $orderable): Collection
    {
        $count    = 1;
        $entities = $orderable::hydrate($entities);
        foreach ($entities as $entity) {
            $entity->{$entity->getOrderColumnName()} = $count;
            $count++;
        }
        return $entities;
    }
}
