<?php

/**
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\InitialConfig;

use App\Repositories\Country\CountryInterface;
use App\Repositories\Department\DepartmentInterface;
use App\Repositories\Municipality\MunicipalityInterface;
use App\Services\Career\CareerManager;
use App\Services\Subject\SubjectManager;
use Carbon\Carbon;

class InitialConfigManager
{
  /**
   * CountryInterface
   *
   * @var App\Repositories\Country\CountryInterface;
   *
   */
  protected $Country;

  /**
   * DepartmentInterface
   *
   * @var App\Repositories\Department\DepartmentInterface;
   *
   */
  protected $Department;

  /**
   * MunicipalityInterface
   *
   * @var App\Repositories\Municipality\MunicipalityInterface;
   *
   */
  protected $Municipality;

  /**
   * CareerManager
   *
   * @var App\Services\Career\CareerManager;
   *
   */
  protected $CareerManager;

  /**
   * SubjectManager
   *
   * @var App\Services\Subject\SubjectManager;
   *
   */
  protected $SubjectManager;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    CountryInterface $Country,
    DepartmentInterface $Department,
    MunicipalityInterface $Municipality,
    CareerManager $CareerManager,
    SubjectManager $SubjectManager,
    Carbon $Carbon
  ) {
    $this->Country = $Country;
    $this->Department = $Department;
    $this->Municipality = $Municipality;
    $this->CareerManager = $CareerManager;
    $this->SubjectManager = $SubjectManager;
    $this->Carbon = $Carbon;
    $this->responseType = 'initialConfig';
  }

  public function getInitialConfig($request)
  {
    return [
      'careers' => $this->CareerManager->getTableRowsWithPagination($request, false)['rows'],
      'subjects' => $this->SubjectManager->getTableRowsWithPagination($request, false)['rows'],
      'countries' => $this->getCountryData(),
    ];
  }

  private function getCountryData()
  {
    $countries = $this->Country->searchTableRowsWithPagination();
    $departments = $this->Department->searchTableRowsWithPagination();
    $municipalities = $this->Municipality->searchTableRowsWithPagination();

    $municipalitiesByDepartment = $municipalities->groupBy('department_id');
    $departmentsByCountry = $departments->groupBy('country_id');

    $countries->each(function ($country) use ($departmentsByCountry, $municipalitiesByDepartment) {
      $country->departments = $this->getDepartmentByCountry($country->value, $departmentsByCountry, $municipalitiesByDepartment);
    });

    return $countries;
  }

  private function getDepartmentByCountry($countryId, $departments, $municipalities)
  {
    return $departments[$countryId]->map(function ($department) use ($municipalities) {
      $department->municipalities = $this->getMunicipalitiesByDepartment($department->value, $municipalities);
      return $department;
    });
  }

  private function getMunicipalitiesByDepartment($departmentId, $municipalities)
  {
    return $municipalities[$departmentId];
  }

}
