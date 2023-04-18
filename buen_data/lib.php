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
 * This file contains transversal methods for Buen Data management.
 *
 * @package     local_buen_data
 * @category    string
 * @copyright   2023 Diego Felipe Monroy Cifuentes <dfelipe.monroyc@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * @param $page
 * @param $per_page
 * @param $onlyvisible
 * @return array
 * @throws dml_exception
 */
function local_buen_data_get_paginated_courses($page, $per_page, $onlyvisible): array {
    global $DB;

    $dbpage = !empty($page) ? $page - 1 : 0; // safe pagination due response will start from 0;
    $limitfrom = $dbpage * $per_page;

    $queryvisible = '';
    if (!empty($onlyvisible)) {
        $queryvisible = ' WHERE c.visible = 1 ';
    }
    $sql = "SELECT c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, cs.name as catname 
            FROM {course} c
            LEFT JOIN {course_categories} cs ON c.category = cs.id
            $queryvisible
            LIMIT $limitfrom, $per_page";

    $courses = $DB->get_records_sql($sql);

    $coursedata = [];
    foreach ($courses as $course) {
        $coursedata[] = [
            'id' => $course->id,
            'fullname' => $course->fullname,
            'shortname' => $course->shortname,
            'summary' => $course->summary,
            'startdate' => date('Y-m-d', $course->startdate),
            'enddate' => date('Y-m-d', $course->enddate),
            'catname' => $course->catname,
        ];
    }
    $jsoncourse = json_encode($coursedata);

    $response = [];
    $response['total'] = count($courses);
    $response['page'] = empty($page) ? 1 : $page; // only for display purporses.
    $response['per_page'] = $per_page;
    $response['total_pages'] = ceil($response['total'] / $per_page);
    $response['data'] = $jsoncourse;

    return $response;
}
