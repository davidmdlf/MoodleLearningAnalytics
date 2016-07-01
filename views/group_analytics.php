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
$students_of_group = get_enrolled_users(context_course::instance($course->id), '', $group->id, 'u.id, u.firstname, u.lastname', 'u.firstname');
echo html_writer::tag('h5', get_string('group_formed_by', "block_moodlean"));
echo html_writer::start_tag('ul', array('class' => 'students_of_group_list'));
foreach($students_of_group as $student) {
    $student_link = html_writer::start_tag('li', array('class' => 'student_of_group'));
    $student_link .= html_writer::tag('a', $student->firstname . ' ' . $student->lastname, array('href' => UrlGenerator::to_student_analytics($student->id )));
    $student_link .= html_writer::end_tag('li');
    echo $student_link;
}
echo html_writer::end_tag('ul');
$all_course_grades = GroupData::get_all_course_grades($group->id, $course->id);
$performance_radar = GroupData::get_performance_radar($group->id, $course->id);
include "templates/dashboard.php";
echo $OUTPUT->footer();