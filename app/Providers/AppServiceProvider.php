<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public const HOME = '/dashboard.buyer'; // or set based on role

public function boot()
{
    Fortify::authenticateUsing(function ($request) {
        $user = User::where('email', $request->email)->first();

        if ($user &&
            Hash::check($request->password, $user->password)) {
            session(['role' => $user->role]);
            return $user;
        }
    });
}

}
