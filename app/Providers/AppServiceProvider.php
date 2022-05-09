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
    $this->registerCurriculumInterface();
    $this->registerPrerequisiteInterface();
    $this->registerCurriculumSubjectInterface();
    $this->registerScholarshipInterface();
    $this->registerStudentCurriculaInterface();

    $this->registerAuthenticationManagement();
    $this->registerStudentManagement();
    $this->registerTeacherManagement();
    $this->registerCareerManagement();
    $this->registerSubjectManagement();
    $this->registerCurriculumManagement();
    $this->registerPrerequisiteManagement();
    $this->registerCurriculumSubjectManagement();
    $this->registerScholarshipManagement();
    $this->registerStudentCurriculaManagement();
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
        $app->make('dompdf.wrapper'),
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

  /**
   * Register a curriculum interface instance.
   *
   * @return void
   */
  protected function registerCurriculumInterface()
  {
    $this->app->bind('App\Repositories\Curriculum\CurriculumInterface', function ($app) {
      return new \App\Repositories\Curriculum\EloquentCurriculum(
        new \App\Models\Curriculum(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a curriculum interface instance.
   *
   * @return void
   */
  protected function registerCurriculumManagement()
  {
    $this->app->bind('App\Services\Curriculum\CurriculumManager', function ($app) {
      return new \App\Services\Curriculum\CurriculumManager(
        $app->make('App\Repositories\Curriculum\CurriculumInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a Prerequisite interface instance.
   *
   * @return void
   */
  protected function registerPrerequisiteInterface()
  {
    $this->app->bind('App\Repositories\Prerequisite\PrerequisiteInterface', function ($app) {
      return new \App\Repositories\Prerequisite\EloquentPrerequisite(
        new \App\Models\Prerequisite(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Prerequisite interface instance.
   *
   * @return void
   */
  protected function registerPrerequisiteManagement()
  {
    $this->app->bind('App\Services\Prerequisite\PrerequisiteManager', function ($app) {
      return new \App\Services\Prerequisite\PrerequisiteManager(
        $app->make('App\Repositories\Prerequisite\PrerequisiteInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a CurriculumSubject interface instance.
   *
   * @return void
   */
  protected function registerCurriculumSubjectInterface()
  {
    $this->app->bind('App\Repositories\CurriculumSubject\CurriculumSubjectInterface', function ($app) {
      return new \App\Repositories\CurriculumSubject\EloquentCurriculumSubject(
        new \App\Models\CurriculumSubject(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a CurriculumSubject interface instance.
   *
   * @return void
   */
  protected function registerCurriculumSubjectManagement()
  {
    $this->app->bind('App\Services\CurriculumSubject\CurriculumSubjectManager', function ($app) {
      return new \App\Services\CurriculumSubject\CurriculumSubjectManager(
        $app->make('App\Repositories\CurriculumSubject\CurriculumSubjectInterface'),
        $app->make('App\Services\Prerequisite\PrerequisiteManager'),
        new Carbon()
      );
    });
  }

  /**
   * Register a Scholarship interface instance.
   *
   * @return void
   */
  protected function registerScholarshipInterface()
  {
    $this->app->bind('App\Repositories\Scholarship\ScholarshipInterface', function ($app) {
      return new \App\Repositories\Scholarship\EloquentScholarship(
        new \App\Models\Scholarship(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Scholarship interface instance.
   *
   * @return void
   */
  protected function registerScholarshipManagement()
  {
    $this->app->bind('App\Services\Scholarship\ScholarshipManager', function ($app) {
      return new \App\Services\Scholarship\ScholarshipManager(
        $app->make('App\Repositories\Scholarship\ScholarshipInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a StudentCurricula interface instance.
   *
   * @return void
   */
  protected function registerStudentCurriculaInterface()
  {
    $this->app->bind('App\Repositories\StudentCurricula\StudentCurriculaInterface', function ($app) {
      return new \App\Repositories\StudentCurricula\EloquentStudentCurricula(
        new \App\Models\StudentCurriculum(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a StudentCurricula interface instance.
   *
   * @return void
   */
  protected function registerStudentCurriculaManagement()
  {
    $this->app->bind('App\Services\StudentCurricula\StudentCurriculaManager', function ($app) {
      return new \App\Services\StudentCurricula\StudentCurriculaManager(
        $app->make('App\Repositories\StudentCurricula\StudentCurriculaInterface'),
        new Carbon()
      );
    });
  }

}
