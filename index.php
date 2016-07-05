<script src="js/jquery.3.0.min.js"></script>
<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Redirects the user to the default grade report
 *
 * @package   core_grades
 * @copyright 2007 Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../config.php';
require_once 'classes/UrlGenerator.php';

$courseid = required_param('course_id', PARAM_INT);

$PAGE->set_url('/moodlean/index.php', array('course_id' => $courseid));

/// basic access checks
if (!$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST)) {
    print_error('nocourseid');
}
if (!$user = $DB->get_record('user', array('id' => required_param('user_id', PARAM_INT)), '*', MUST_EXIST)) {
    print_error('nouserid');
}
if (!$type = $_GET['type']) {
    print_error('notype');
}
require_login($course);

$PAGE->set_pagetype('course-view-' . $course->format);  // To get the blocks exactly like the course.
$PAGE->add_body_class('path-user');                     // So we can style it independently.

$PAGE->set_title(get_string('pluginname', "block_moodlean") . " | $course->fullname: $user->firstname $user->lastname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

$is_comparator_selection = false;
if(isset($_GET['is_comparator'])){
    $is_comparator_selection = true;
}

echo $OUTPUT->header();

switch ($type) {
    case 'student':
        echo '<div class="tab-50'.($is_comparator_selection?'':' selected').'">';
        echo '<a href="'.UrlGenerator::to_student_selection().'">'.get_string("see_by_student", "block_moodlean").'</a>';
        echo '</div>';
        echo '<div class="tab-50'.($is_comparator_selection?' selected':'').'">';
        echo '<a href="'.UrlGenerator::to_student_comparation_selection().'">'.get_string("compare", "block_moodlean").'</a>';
        echo '</div>';echo '<section class="tabs-section">';
        break;
    case 'group':
        echo '<div class="tab-50'.($is_comparator_selection?'':' selected').'">';
        echo '<a href="'.UrlGenerator::to_group_selection().'">'.get_string("see_by_group", "block_moodlean").'</a>';
        echo '</div>';
        echo '<div class="tab-50'.($is_comparator_selection?' selected':'').'">';
        echo '<a href="'.UrlGenerator::to_group_comparation_selection().'">'.get_string("compare", "block_moodlean").'</a>';
        echo '</div>';echo '<section class="tabs-section">';        break;
}


echo '<ul class="analytics_single_selector">';
switch ($type) {
    case 'student':
        $students = get_enrolled_users(context_course::instance($course->id), '', '', 'u.id, u.firstname, u.lastname', 'u.firstname');
        break;
    case 'group':
        $groups = groups_get_course_data($courseid);
        break;
}

if(!$is_comparator_selection) {
    switch ($type) {
        case 'student':
            foreach ($students as $student) {
                echo '<li><a href="' . UrlGenerator::to_student_analytics($student->id) . '">' . $student->firstname . ' ' . $student->lastname . '</a></li>';
            }
            break;
        case 'group':
            foreach ($groups->groups as $group) {
                echo '<li><a href="' . UrlGenerator::to_group_analytics($group->id) . '">' . $group->name . '</a></li>';
            }
            break;
    }
    echo '</ul>';
}
if($is_comparator_selection) {
    echo '<form class="analytics_multiple_selector" method="post" action="analytics.php">';
    switch ($type) {
        case 'student':
            foreach ($students as $student) {
                echo '<div><input class="analytics_entity_checkbox" type="checkbox" name="student_ids['.$student->id.']" value="' . $student->id . '">' . $student->firstname . ' ' . $student->lastname . '</input></div>';
            }
            break;
        case 'group':
            foreach ($groups->groups as $group) {
                echo '<div><input class="analytics_entity_checkbox" type="checkbox" name="group_ids['.$group->id.']"  value="' . $group->id . '">' . $group->name . '</input></div>';
            }
            break;
    }
    echo '<div><input type="hidden" name="course_id" value="' . $courseid. '">';
    echo '<div><input type="hidden" name="type" value="' . $type. '">';
    echo '<div><input type="submit" value="' . get_string("compare", "block_moodlean") . '">';
    echo '</form>';
}
echo '</section>';
echo $OUTPUT->footer();

?>
<script>
    $(function(){
        $('.analytics_entity_checkbox').change(function(){
            console.log('changing');
            if($('.analytics_entity_checkbox:checked').length > 5){
                alert('<?php echo get_string('no_more_selections_allowed', 'block_moodlean'); ?>');
                $(this).prop('checked', false)
            }
        });
    })
</script>
