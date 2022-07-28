<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Passport::routes();
    Passport::tokensExpireIn(now()->addMinutes(120));
    Passport::refreshTokensExpireIn(now()->addDays(1));
    Passport::personalAccessTokensExpireIn(now()->addMinutes(120));

    // Implicitly grant "Super-Admin" role all permission checks using can()
    Gate::before(function ($user, $ability) {
      dd('Invoked GATE');
      return $user->hasRole('Super Admin') ? true : null;
    });
  }
}
