<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/lib/moodlelib.php');


if ($ADMIN->fulltree) {
    //Student permission to see analytics
    $options = array('true' => get_string('enabled', 'block_moodlean'), 'false' => get_string('disabled', 'block_moodlean'));
    $settings->add(new admin_setting_configselect('block_moodlean/student_allowed', get_string('student_allowed', 'block_moodlean'), get_string('student_allowed_description', 'block_moodlean'), 'false', $options));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_color_1', get_string('chart_color', 'block_moodlean', 1), get_string('chart_color_description', 'block_moodlean', 1), '#FF6384'));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_color_2', get_string('chart_color', 'block_moodlean', 2), get_string('chart_color_description', 'block_moodlean', 2), '#00BFFF'));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_color_3', get_string('chart_color', 'block_moodlean', 3), get_string('chart_color_description', 'block_moodlean', 3), '#D358F7'));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_color_4', get_string('chart_color', 'block_moodlean', 4), get_string('chart_color_description', 'block_moodlean', 4), '#58FA58'));
    $settings->add(new admin_setting_configcolourpicker ('block_moodlean/chart_color_5', get_string('chart_color', 'block_moodlean', 5), get_string('chart_color_description', 'block_moodlean', 5), '#FE9A2E'));
    $settings->add(new admin_setting_configtext ('block_moodlean/chart_background_opacity', get_string('chart_background_opacity', 'block_moodlean'), get_string('chart_opacity_description', 'block_moodlean'), 20, PARAM_INT));
    $settings->add(new admin_setting_configtext ('block_moodlean/chart_line_opacity', get_string('chart_line_opacity', 'block_moodlean'), get_string('chart_opacity_description', 'block_moodlean'), 100, PARAM_INT));
}
