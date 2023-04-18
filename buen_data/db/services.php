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
 * @package     local_buen_data
 * @category    services
 * @copyright   2023 Diego Felipe Monroy Cifuentes <dfelipe.monroyc@gmail.com>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$functions = [
    'local_buen_data_get_paginated_courses' => [
        'classname' => 'local_buen_data\external',
        'methodname' => 'get_paginated_courses',
        'ajax' => true,
        'description' => '',
        'type' => 'read',
    ]
];

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = [
    'Buen Data Courses WS' =>
        [
            'functions' => [
                'local_buen_data_get_paginated_courses'
            ],
            'restrictedusers' => 0,
            'enabled' => 1,
        ],
];
