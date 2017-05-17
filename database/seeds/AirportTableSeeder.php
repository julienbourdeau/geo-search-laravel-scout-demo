<?php

use Illuminate\Database\Seeder;

class AirportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Airport::truncate();

        $data = json_decode(
            file_get_contents(resource_path('datasets/airports.json')),
            true
        );

        foreach ($data as $airport) {
            DB::table('airports')->insert([
                'id' => $airport['objectID'],
                'name' => $airport['name'],
                'city' => $airport['city'],
                'country' => $airport['country'],
                'latitude' => $airport['_geoloc']['lat'],
                'longitude' => $airport['_geoloc']['lng'],
                'iata_code' => $airport['iata_code'],
                'links_count' => $airport['links_count'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
