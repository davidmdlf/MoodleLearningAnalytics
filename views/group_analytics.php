<?php
/**
 * Group analytics general template.
 *
 * Author: David Miguel de la Fuente
 */
require_once('classes/GroupData.php');


if (!$group = $DB->get_record('groups', array('id' => required_param('group_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nogroupid');
}

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $group->name");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

include "templates/fragments/header.php";
$all_course_grades = GroupData::get_all_course_grades($group->id, $course->id);
$performance_radar = GroupData::get_performance_radar($group->id, $course->id);
include "templates/dashboard.php";
echo $OUTPUT->footer();