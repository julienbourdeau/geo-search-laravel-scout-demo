<?php
namespace App\Search;

use Laravel\Scout\Searchable;

trait GeoSearchable
{
    use Searchable;

    public static function searchAround($query, $lat, $lng, $radius = 10, $callback = null)
    {
        $location = [
            'aroundLatLng' => $lat.','.$lng,
            'aroundRadius' => $radius * 1000
        ];

        return static::search($query, function ($algolia, $query, $options) use ($location, $callback) {
            $options = array_merge($options, $location);

            if ($callback) {
                return call_user_func(
                    $callback,
                    $algolia,
                    $query,
                    $options
                );
            }

            return $algolia->search($query, $options);
        });
    }
}
