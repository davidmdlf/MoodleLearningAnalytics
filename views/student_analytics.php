<?php
/**
 * Student analytics general template.
 *
 * Author: David Miguel de la Fuente
 */
require_once('classes/UserData.php');

if (!$course = $DB->get_record('course', array('id' => required_param('course_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nocourseid');
}
if (!$student = $DB->get_record('user', array('id' => required_param('student_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nouserid');
}

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $student->firstname $student->lastname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

include "templates/fragments/header.php";
$all_course_grades = UserData::get_all_course_grades($student->id, $course->id);
$performance_radar = UserData::get_performance_radar($student->id, $course->id);
include "templates/dashboard.php";
echo $OUTPUT->footer();