<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    //Student permission to see analytics
    $options = array('true' => get_string('enabled', 'block_moodlean'), 'false' => get_string('disabled', 'block_moodlean'));
    $settings->add(new admin_setting_configselect('block_moodlean/student_allowed', get_string('student_allowed', 'block_moodlean'), get_string('student_allowed_description', 'block_moodlean'), 'false', $options));
}
