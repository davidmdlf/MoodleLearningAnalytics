<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 17/05/2016
 * Time: 20:01
 */
require_once '../../config.php';
require_once($CFG->dirroot.'/rating/lib.php');


/// basic access checks
if (!$course = $DB->get_record('course', array('id' => $_GET['course_id']), '*', MUST_EXIST)) {
    print_error('nocourseid');
}if (!$type = $_GET['type']) {
    print_error('notype');
}

$PAGE->set_url('/moodlean/analytics.php', array('id' => $course->id));
require_login($course);

switch($type){
    case 'student':
        include 'views/student_analytics.php'; break;
    case 'group':
        include 'views/group_analytics.php'; break;
    case 'class':
        include 'views/class_analytics.php'; break;
}