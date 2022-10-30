<?php

namespace App\Providers;

use App\Repositories\Roles\EloquentRoles;
use App\Services\Roles\RoleManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
    Schema::defaultStringLength(191);
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
    $this->registerPeriodInterface();
    $this->registerSectionInterface();
    $this->registerEnrollmentInterface();
    $this->registerEvaluationInterface();
    $this->registerScoreEvaluationInterface();
    $this->registerCountryInterface();
    $this->registerDepartmentInterface();
    $this->registerMunicipalityInterface();
    $this->registerScheduleInterface();
    $this->registerAuthenticationManagement();
    $this->registerStudentManagement();
    $this->registerTeacherManagement();
    $this->registerUserManagement();
    $this->registerCareerManagement();
    $this->registerScheduleManagement();
    $this->registerSubjectManagement();
    $this->registerCurriculumManagement();
    $this->registerPrerequisiteManagement();
    $this->registerCurriculumSubjectManagement();
    $this->registerScholarshipManagement();
    $this->registerStudentCurriculaManagement();
    $this->registerPeriodManagement();
    $this->registerSectionManagement();
    $this->registerEnrollmentManagement();
    $this->registerEvaluationManagement();
    $this->registerScoreEvaluationManagement();
    $this->registerInitialConfigManagement();

    $this->registerRolesInterface();
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
        $app->make('App\Repositories\User\UserInterface'),
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
        $app->make('App\Repositories\User\UserInterface'),
        $app->make('App\Repositories\Section\SectionInterface'),
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
  protected function registerUserManagement()
  {
    $this->app->bind('App\Services\User\UserManager', function ($app) {
      return new \App\Services\User\UserManager(

        $app->make('App\Repositories\User\UserInterface'),
        $app->make('dompdf.wrapper'),
        new Carbon()
      );
    });
  }
  protected function registerRolesInterface()
  {
    $this->app->bind('App\Repositories\Roles\RoleInterface', function ($app) {
      return new EloquentRoles();
    });
  }
  protected function registerRoleManagement()
  {
    $this->app->bind('App\Services\Roles\RoleManager', function ($app) {
      return new RoleManager(
        $app->make('App\Repositories\Roles\RoleInterface')
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

  /**
   * Register a Period interface instance.
   *
   * @return void
   */
  protected function registerPeriodInterface()
  {
    $this->app->bind('App\Repositories\Period\PeriodInterface', function ($app) {
      return new \App\Repositories\Period\EloquentPeriod(
        new \App\Models\CurriculumSubject(),
        new \App\Models\StudentCurriculum(),
        new \App\Models\Enrollment(),
        new \App\Models\Period(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Period interface instance.
   *
   * @return void
   */
  protected function registerPeriodManagement()
  {
    $this->app->bind('App\Services\Period\PeriodManager', function ($app) {
      return new \App\Services\Period\PeriodManager(
        $app->make('App\Repositories\Period\PeriodInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a Section interface instance.
   *
   * @return void
   */
  protected function registerSectionInterface()
  {
    $this->app->bind('App\Repositories\Section\SectionInterface', function ($app) {
      return new \App\Repositories\Section\EloquentSection(
        new \App\Models\Section(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Section interface instance.
   *
   * @return void
   */
  protected function registerSectionManagement()
  {
    $this->app->bind('App\Services\Section\SectionManager', function ($app) {
      return new \App\Services\Section\SectionManager(
        $app->make('App\Repositories\Section\SectionInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a Enrollment interface instance.
   *
   * @return void
   */
  protected function registerEnrollmentInterface()
  {
    $this->app->bind('App\Repositories\Enrollment\EnrollmentInterface', function ($app) {
      return new \App\Repositories\Enrollment\EloquentEnrollment(
        new \App\Models\Enrollment(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Enrollment interface instance.
   *
   * @return void
   */
  protected function registerEnrollmentManagement()
  {
    $this->app->bind('App\Services\Enrollment\EnrollmentManager', function ($app) {
      return new \App\Services\Enrollment\EnrollmentManager(
        $app->make('App\Repositories\Enrollment\EnrollmentInterface'),
        new Carbon()
      );
    });
  }

  /**
   * Register a Evaluation interface instance.
   *
   * @return void
   */
  protected function registerEvaluationInterface()
  {
    $this->app->bind('App\Repositories\Evaluation\EvaluationInterface', function ($app) {
      return new \App\Repositories\Evaluation\EloquentEvaluation(
        
        new \App\Models\Evaluation(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a Evaluation interface instance.
   *
   * @return void
   */
  protected function registerEvaluationManagement()
  {
    $this->app->bind('App\Services\Evaluation\EvaluationManager', function ($app) {
      return new \App\Services\Evaluation\EvaluationManager(
        $app->make('App\Repositories\Enrollment\EnrollmentInterface'),
        $app->make('App\Repositories\ScoreEvaluation\ScoreEvaluationInterface'),
        $app->make('App\Repositories\Evaluation\EvaluationInterface'),
        new Carbon()
      );
    });
  }
  /**
   * Register a Evaluation interface instance.
   *
   * @return void
   */
  protected function registerScheduleInterface()
  {
    $this->app->bind('App\Repositories\Schedule\ScheduleInterface', function ($app) {
      return new \App\Repositories\Schedule\EloquentSchedule(
        new \App\Models\Schedule(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }
  /**
   * Register a Evaluation interface instance.
   *
   * @return void
   */
  protected function registerScheduleManagement()
  {
    $this->app->bind('App\Services\Schedule\ScheduleManager', function ($app) {
      return new \App\Services\Schedule\ScheduleManager(
        $app->make('App\Repositories\Schedule\ScheduleInterface'),
        new Carbon()
      );
    });
  }
  /**
   * Register a ScoreEvaluation interface instance.
   *
   * @return void
   */
  protected function registerScoreEvaluationInterface()
  {
    $this->app->bind('App\Repositories\ScoreEvaluation\ScoreEvaluationInterface', function ($app) {
      return new \App\Repositories\ScoreEvaluation\EloquentScoreEvaluation(
        new \App\Models\ScoreEvaluation(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a ScoreEvaluation interface instance.
   *
   * @return void
   */
  protected function registerScoreEvaluationManagement()
  {
    $this->app->bind('App\Services\ScoreEvaluation\ScoreEvaluationManager', function ($app) {
      return new \App\Services\ScoreEvaluation\ScoreEvaluationManager(
        $app->make('App\Repositories\ScoreEvaluation\ScoreEvaluationInterface'),
    
        new Carbon()
      );
    });
  }

  /**
   * Register a Country interface instance.
   *
   * @return void
   */
  protected function registerCountryInterface()
  {
    $this->app->bind('App\Repositories\Country\CountryInterface', function ($app) {
      return new \App\Repositories\Country\EloquentCountry(
        new \App\Models\Country(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }

  /**
   * Register a Department interface instance.
   *
   * @return void
   */
  protected function registerDepartmentInterface()
  {
    $this->app->bind('App\Repositories\Department\DepartmentInterface', function ($app) {
      return new \App\Repositories\Department\EloquentDepartment(
        new \App\Models\Department(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }

  /**
   * Register a Municipality interface instance.
   *
   * @return void
   */
  protected function registerMunicipalityInterface()
  {
    $this->app->bind('App\Repositories\Municipality\MunicipalityInterface', function ($app) {
      return new \App\Repositories\Municipality\EloquentMunicipality(
        new \App\Models\Municipality(),
        new \Illuminate\Support\Facades\DB()
      );
    });
  }


  /**
   * Register a InitialConfig interface instance.
   *
   * @return void
   */
  protected function registerInitialConfigManagement()
  {
    $this->app->bind('App\Services\InitialConfig\InitialConfigManager', function ($app) {
      return new \App\Services\InitialConfig\InitialConfigManager(
        $app->make('App\Repositories\Country\CountryInterface'),
        $app->make('App\Repositories\Department\DepartmentInterface'),
        $app->make('App\Repositories\Municipality\MunicipalityInterface'),
        $app->make('App\Services\Career\CareerManager'),
        $app->make('App\Services\Subject\SubjectManager'),
        $app->make('App\Services\Curriculum\CurriculumManager'),
        $app->make('App\Services\CurriculumSubject\CurriculumSubjectManager'),
        new Carbon(),
        $app->make('App\Services\Schedule\ScheduleManager'),
      );
    });
  }

}
