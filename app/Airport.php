<?php

namespace App;

use Algolia\AdvancedScout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        $record = $this->toArray();

        $record['_geoloc'] = [
            'lat' => $record['latitude'],
            'lng' => $record['longitude'],
        ];

        unset($record['created_at'], $record['updated_at']); // Pro tips
        unset($record['latitude'], $record['longitude']);

        return $record;
    }
}
