<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 17/05/2016
 * Time: 21:02
 */
if (!$student = $DB->get_record('user', array('id' => required_param('student_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nouserid');
}

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $student->firstname $student->lastname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

$ratingoptions = new stdClass;
$ratingoptions->component = 'mod_quizz';
$ratingoptions->modulename = 'quizz';
$ratingoptions->userid = $student->id;
$ratingoptions->itemtable = 'quizz_attempts';
$ratingoptions->scaleid = 'quizz_attempts';
$ratingoptions->itemtableusercolumn = 'userid';
$ratingoptions->ratingarea = 'attempts';

$rm = new rating_manager();
return $rm->get_user_grades($ratingoptions);

echo $OUTPUT->header();
echo $student->firstname;
echo $OUTPUT->footer();