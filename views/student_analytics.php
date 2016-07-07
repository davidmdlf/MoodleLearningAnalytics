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
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: " .get_string('compare', "block_moodlean"));
    $student_ids = $_POST['student_ids'];
} else {
    if (!$student = $DB->get_record('user', array('id' => required_param('student_id', PARAM_INT)), '*', MUST_EXIST)) {
        print_error('nouserid');
    }
    $PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $student->firstname $student->lastname");
    $student_ids = array($student->id);
}

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

$is_comparation ? include "templates/fragments/comparator_header.php" : include "templates/fragments/header.php";
$all_course_grades = UserData::get_all_course_grades_for_multiple_users($student_ids, $course->id);
$performance_radar = UserData::get_performance_radar_for_multiple_users($student_ids, $course->id);
include "templates/dashboard.php";
echo $OUTPUT->footer();