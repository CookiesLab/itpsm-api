<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if (env('REDIRECT_HTTPS')) {
      $this->app['request']->server->set('HTTPS', true);
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(UrlGenerator $url)
  {
    if (env('REDIRECT_HTTPS')) {
      $url->formatScheme('https://');
    }

    $this->registerUserInterface();
    $this->registerStudentInterface();

    $this->registerAuthenticationManagement();
    $this->registerStudentManagement();
  }

  /**
   * Register a user interface instance.
   *
   * @return void
   */
  protected function registerUserInterface()
  {
    $this->app->bind('App\Repositories\User\UserInterface', function ($app) {
      return new \App\Repositories\User\EloquentUser(new \App\Models\User());
    });
  }


  /**
   * Register a user interface instance.
   *
   * @return void
   */
  protected function registerAuthenticationManagement()
  {
    $this->app->bind('App\Services\Authentication\AuthenticationManager', function ($app) {
      return new \App\Services\Authentication\AuthenticationManager(
        $app->make('App\Repositories\User\UserInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a user interface instance.
   *
   * @return void
   */
  protected function registerStudentInterface()
  {
    $this->app->bind('App\Repositories\Student\StudentInterface', function ($app) {
      return new \App\Repositories\Student\EloquentStudent(
        new \App\Models\Student(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a user interface instance.
   *
   * @return void
   */
  protected function registerStudentManagement()
  {
    $this->app->bind('App\Services\Student\StudentManager', function ($app) {
      return new \App\Services\Student\StudentManager(
        $app->make('App\Repositories\Student\StudentInterface'),
        new Carbon()
      );
    });
  }
}
