<?php

class block_moodlean extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_moodlean');
    }

    function has_config()
    {
        return true;
    }

    public function get_content()
    {
        if ($this->content) {
            return $this->content;
        }
        global $COURSE, $USER, $DB, $CFG;

        $la_config = get_config('block_moodlean');

        $this->content = new stdClass;
        if (isset($la_config->students_allowed) && !$la_config->students_allowed) {
            return $this->content;
        }

        $course = $DB->get_record('course', array('id' => $COURSE->id));
        $this->content->text = html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/moodlean/pix/icon.png', 'alt' => ''));
        $this->content->text .= html_writer::tag('span', get_string('see_analytics_for', 'block_moodlean')) . $course->fullname;

        $params = array(
            'id' => $COURSE->id,
            'user_id' => $USER->id);
        $params['type'] = 'student';
        $list = html_writer::tag('p', html_writer::tag('a', html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/moodlean/img/student-icon.png', 'alt' => '')) . get_string('see_by_student', 'block_moodlean'), array('href' => $CFG->wwwroot.'/blocks/moodlean/index.php?' . http_build_query($params, '', '&'))));
        $params['type'] = 'group';
        $list .= html_writer::tag('p', html_writer::tag('a', html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/moodlean/img/group-icon.png', 'alt' => '')) . get_string('see_by_group', 'block_moodlean'), array('href' => $CFG->wwwroot.'/blocks/moodlean/index.php?' . http_build_query($params, '', '&'))));
        $params['type'] = 'class';
        $list .= html_writer::tag('p', html_writer::tag('a', html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/moodlean/img/class-icon.png', 'alt' => '')) . get_string('see_by_class', 'block_moodlean'), array('href' => $CFG->wwwroot.'/blocks/moodlean/index.php?' . http_build_query($params, '', '&'))));

        $this->content->text .= $list;
        return $this->content;
    }
}