<?php

namespace App\Providers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        LumenPassport::routes($this->app, ['prefix' => 'v1/oauth']);
        LumenPassport::allowMultipleTokens();

        // Second parameter is the client Id
        LumenPassport::tokensExpireIn(Carbon::now()->addMinutes(10), 2);
        
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('passport', function ($request) {
//            if ($request->bearerToken()) {
//                dd($request->bearerToken())
//                return User::where('id', 1)->first();
//             }
        });
    }
}
