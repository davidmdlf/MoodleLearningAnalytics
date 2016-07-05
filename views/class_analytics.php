<?php
/**
 * Student analytics general template.
 *
 * Author: David Miguel de la Fuente
 */
require_once('classes/ClassData.php');

if (!$course = $DB->get_record('course', array('id' => required_param('course_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nocourseid');
}

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: ".get_string("see_by_class", "block_moodlean"));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

$is_comparation ? include "templates/fragments/comparator_header.php" : include "templates/fragments/header.php";
$all_course_grades = array(ClassData::get_all_course_grades($course->id));
$performance_radar = array(ClassData::get_performance_radar($course->id));
include "templates/dashboard.php";
echo $OUTPUT->footer();