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
    $this->registerTeacherInterface();
    $this->registerCareerInterface();
    $this->registerSubjectInterface();

    $this->registerAuthenticationManagement();
    $this->registerStudentManagement();
    $this->registerTeacherManagement();
    $this->registerCareerManagement();
    $this->registerSubjectManagement();
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

  /**
   * Register a teacher interface instance.
   *
   * @return void
   */
  protected function registerTeacherInterface()
  {
    $this->app->bind('App\Repositories\Teacher\TeacherInterface', function ($app) {
      return new \App\Repositories\Teacher\EloquentTeacher(
        new \App\Models\Teacher(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a teacher interface instance.
   *
   * @return void
   */
  protected function registerTeacherManagement()
  {
    $this->app->bind('App\Services\Teacher\TeacherManager', function ($app) {
      return new \App\Services\Teacher\TeacherManager(
        $app->make('App\Repositories\Teacher\TeacherInterface'),
        new Carbon()
      );
    });
  }
}


/**
   * Register a career interface instance.
   *
   * @return void
   */
  protected function registerCareerInterface()
  {
    $this->app->bind('App\Repositories\Career\CareerInterface', function ($app) {
      return new \App\Repositories\Career\EloquentCareer(
        new \App\Models\Career(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a career interface instance.
   *
   * @return void
   */
  protected function registerCareerManagement()
  {
    $this->app->bind('App\Services\Career\CareerManager', function ($app) {
      return new \App\Services\Career\CareerManager(
        $app->make('App\Repositories\Career\CareerInterface'),
        new Carbon()
      );
    });
  }
}

/**
   * Register a subject interface instance.
   *
   * @return void
   */
  protected function registerSubjectInterface()
  {
    $this->app->bind('App\Repositories\Subject\SubjectInterface', function ($app) {
      return new \App\Repositories\Subject\EloquentSubject(
        new \App\Models\Subject(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a subject interface instance.
   *
   * @return void
   */
  protected function registerSubjectManagement()
  {
    $this->app->bind('App\Services\Subject\SubjectManager', function ($app) {
      return new \App\Services\Subject\SubjectManager(
        $app->make('App\Repositories\Subject\SubjectInterface'),
        new Carbon()
      );
    });
  }
}
