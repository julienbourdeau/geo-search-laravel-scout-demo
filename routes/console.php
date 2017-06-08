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

Artisan::command('geosearch2 {query} {lat} {lng} {radius}', function ($query, $lat, $lng, $radius) {
    dd(\App\Airport::searchAround($query, $lat, $lng, $radius)->get());
})->describe('Simple search for an Airport, but easier');

Artisan::command('searchuk {query}', function ($query) {
    dd(\App\Airport::search($query, function ($algolia, $query, $options) {
        $polygonAroundTheUK = [
            52.9332312, -1.9937525, // Point 1 lat, lng
            52.1312677, -2.0434894, // Point 2 lat, lng
            52.7029492,-1.2530685, // Point 3 lat, lng
            51.5262792, 0.1192389, // Point 4 lat, lng
            48.8364598, 1.7006836, // Point 5 lat, lng
        ];

        $location = [
            'insidePolygon' => [$polygonAroundTheUK]
        ];

        $options = array_merge($options, $location);

        return $algolia->search($query, $options);
    })->get());
})->describe('Search for an airport in the UK');


Artisan::command('count {query}', function ($query) {
    $count = \App\Airport::search($query)->count();

    dd($count);
})->describe('Total count of results');

Artisan::command('geo {query} {lat} {lng} {radius}', function ($query, $lat, $lng, $radius) {
    $result = \App\Airport::search($query)
        ->around($lat, $lng, $radius)
        ->get(); // ->count() works as well

    dd($result);
})->describe('Total count of results');
