<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user = null) {
            $view_tokens = explode(',', config('horizon.view_tokens'));

            $can_view_horizon = in_array(request()->get('view_token'), $view_tokens) || session()->has('can_view_horizon');

            if ($can_view_horizon && !session()->has('can_view_horizon')) {
                session()->put('can_view_horizon', true);
            }

            return $can_view_horizon;
        });
    }
}
