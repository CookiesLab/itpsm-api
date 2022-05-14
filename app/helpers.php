<?php

/*
|--------------------------------------------------------------------------
| Integrating Sentry Logging
|--------------------------------------------------------------------------
|
*/

/**
 * @file
 * Custom system helpers
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

if (!function_exists('encode_requested_data')) {
  /**
   * Enconde requested data
   *
   * @param  array $input
   * @param  integer $count total number of records
   * @param  integer $limit number of rows to be shown into the grid
   * @param  integer $offset start position
   *
   * @return array
   */
  function encode_requested_data($input, $count, &$limit, &$offset, &$totalPages, &$page)
  {
    if (!empty($input['page']['number'])) {
      $page = (int)$input['page']['number'];
    } else {
      $page = 1;
    }

    if (!empty($input['page']['size'])) {
      $limit = (int)$input['page']['size'];
    } else {
      $limit = 10;
    }

    if ($page == 0) {
      $page = 1;
    }

    if ($count > 0) {
      $totalPages = ceil($count / $limit);
    } else {
      $totalPages = 0;
    }

    if ($page > $totalPages) {
      $page = $totalPages;
    }

    if ($limit < 0) {
      $limit = 0;
    }

    $offset = $limit * $page - $limit;

    if ($offset < 0) {
      $offset = 0;
    }
  }
}

if (!function_exists('get_keys_data')) {
  /**
   * Enconde requested data
   *
   * @param  array $input
   * @param  integer $count total number of records
   * @param  integer $limit number of rows to be shown into the grid
   * @param  integer $offset start position
   *
   * @return array
   */
  function get_keys_data($ids)
  {
    return explode('_', $ids);
  }
}
