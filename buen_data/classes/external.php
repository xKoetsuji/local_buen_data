<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package     local_buendata
 * @category    external class.
 * @copyright   2023 Diego Felipe Monroy Cifuentes <dfelipe.monroyc@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_buen_data;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . "/externallib.php");
require_once($CFG->dirroot . '/local/buen_data/lib.php');

use external_api;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;
use core_user;
use context_system;

class external extends external_api {

    /**
     * @return external_function_parameters
     */
    public static function get_paginated_courses_parameters() {
        return new external_function_parameters([
            'page' => new external_value(PARAM_INT, 'Page to Return', VALUE_DEFAULT, 0),
            'per_page' => new external_value(PARAM_INT, 'Number of courses to return by page', VALUE_DEFAULT, 10),
            'only_visible' => new external_value(PARAM_INT, 'Return only visible courses', VALUE_DEFAULT, 0)
        ]);
    }

    /**
     * @return external_multiple_structure
     */
    public static function get_paginated_courses_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                [
                    'total' => new external_value(PARAM_TEXT, 'Total Courses', VALUE_OPTIONAL),
                    'page' => new external_value(PARAM_INT, 'Current Page', VALUE_OPTIONAL),
                    'per_page' => new external_value(PARAM_INT, 'Courses By Page', VALUE_OPTIONAL),
                    'total_pages' => new external_value(PARAM_INT, 'Total Pages', VALUE_OPTIONAL),
                    'data' => new external_value(PARAM_RAW, 'Courses Data', VALUE_OPTIONAL),
                ],
                'Paginated Courses'
            )
        );
    }

    /**
     * @param $page
     * @param $per_page
     * @param $only_visible
     * @return false|string
     * @throws \dml_exception
     */
    public static function get_paginated_courses($page, $per_page, $only_visible) {
        $response = local_buen_data_get_paginated_courses($page, $per_page, $only_visible);

        return [$response];
    }
}
