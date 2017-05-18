<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('search {query}', function ($query) {
    dd(\App\Airport::search($query)->get());
})->describe('Simple search for an Airport');

Artisan::command('geosearch {lat} {lng} {radius}', function ($lat, $lng, $radius) {
    dd(\App\Airport::search('', function ($algolia, $query, $options) use ($lat, $lng, $radius) {
        $location =  [
            'aroundLatLng' => $lat.','.$lng,
            'aroundRadius' => $radius * 1000,
        ];

        $options = array_merge($options, $location);

        return $algolia->search($query, $options);
    })->get());
})->describe('Simple search for an Airport');
