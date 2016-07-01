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
 * Redirects the user to the default grade report
 *
 * @package   core_grades
 * @copyright 2007 Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../config.php';
require_once 'classes/UrlGenerator.php';

$courseid = required_param('course_id', PARAM_INT);

$PAGE->set_url('/moodlean/index.php', array('course_id' => $courseid));

/// basic access checks
if (!$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST)) {
    print_error('nocourseid');
}
if (!$user = $DB->get_record('user', array('id' => required_param('user_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nouserid');
}
if (!$type = $_GET['type']) {
    print_error('notype');
}
require_login($course);

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $user->firstname $user->lastname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
echo '<ul>';
switch ($type) {
    case 'student':
        $students = get_enrolled_users(context_course::instance($courseid));
        foreach ($students as $student) {
            echo '<li><a href="' . UrlGenerator::to_student_analytics($student->id) . '">' . $student->firstname . ' ' . $student->lastname . '</a></li>';
        }
        break;
    case 'group':
        $groups = groups_get_course_data($courseid);
        foreach ($groups->groups as $group) {
            echo '<li><a href="'. UrlGenerator::to_group_analytics($group->id) .'">' . $group->name . '</a></li>';
        }
        break;
}
echo '</ul>';
echo $OUTPUT->footer();