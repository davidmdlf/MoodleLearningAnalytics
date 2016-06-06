<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/lib/moodlelib.php');


if ($ADMIN->fulltree) {
    //Student permission to see analytics
    $options = array('true' => get_string('enabled', 'block_moodlean'), 'false' => get_string('disabled', 'block_moodlean'));
    $settings->add(new admin_setting_configselect('block_moodlean/student_allowed', get_string('student_allowed', 'block_moodlean'), get_string('student_allowed_description', 'block_moodlean'), 'false', $options));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_primary_color', get_string('chart_primary_color', 'block_moodlean'), get_string('chart_primary_color_description', 'block_moodlean'), '#FF6384'));
    $settings->add(new admin_setting_configtext ('block_moodlean/chart_background_opacity', get_string('chart_background_opacity', 'block_moodlean'), get_string('chart_opacity_description', 'block_moodlean'), 20, PARAM_INT));
    $settings->add(new admin_setting_configtext ('block_moodlean/chart_line_opacity', get_string('chart_line_opacity', 'block_moodlean'), get_string('chart_opacity_description', 'block_moodlean'), 100, PARAM_INT));
}
