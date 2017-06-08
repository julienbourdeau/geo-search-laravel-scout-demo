<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Extend Scout Builder with Macros
        \Laravel\Scout\Builder::macro('count', function () {
            $raw = $this->engine()->search($this);

            return (int) $raw['nbHits'];
        });

        \Laravel\Scout\Builder::macro('around', function ($lat, $lng, $radius) {

            $location = [
                'aroundLatLng' => $lat.','.$lng,
                'aroundRadius' => $radius
            ];
            $callback = $this->callback;

            $this->callback = function ($algolia, $query, $options) use ($location, $callback) {
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
            };

            return $this;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
