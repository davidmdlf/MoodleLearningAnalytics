<?php
/**
 * UserData class with static methods to retrieve learning analytics for students
 *
 * Author: David Miguel de la Fuente
 */
require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot .'/grade/querylib.php');

class UserData {
    static function get_all_course_grades_for_multiple_users($user_ids, $course_id) {
        $grade_sets = [];
        foreach($user_ids as $user_id){
            $grade_sets[] = UserData::get_all_course_grades($user_id, $course_id);
        }
        return $grade_sets;
    }

    static function get_all_course_grades($user_id, $course_id){
        global $DB;
        $query = "SELECT grade_items.id, ((grade_grades.finalgrade - grade_items.grademin)/(grade_items.grademax - grade_items.grademin))*10 as grade, grade_items.itemname FROM {grade_items} grade_items JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid WHERE grade_grades.userid = :user_id AND (grade_items.itemtype = 'mod' OR grade_items.itemtype = 'manual') AND grade_items.courseid = :course_id ";
        $records = $DB->get_records_sql($query, array("user_id" => $user_id, "course_id" => $course_id));
        $grades = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = "'".$record->itemname."'";
            $grades[] = $record->grade;
        }
        $student = $DB->get_record('user', array("id" => $user_id));
        return array(
            'label' => $student->firstname . " " . $student->lastname,
            'values' => $grades,
            'labels' => $labels
        );
    }

    static function get_performance_radar_for_multiple_users($user_ids, $course_id) {
        $grade_sets = [];
        foreach($user_ids as $user_id){
            $grade_sets[] = UserData::get_performance_radar($user_id, $course_id);
        }
        return $grade_sets;
    }
    static function get_performance_radar($user_id, $course_id){
        global $DB;
        $query = "SELECT grade_items.itemmodule, (AVG(grade_grades.finalgrade)/AVG(grade_items.grademax)) AS avggraderatio FROM {grade_items} grade_items JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid WHERE grade_grades.userid = :user_id AND (grade_items.itemtype = 'mod' OR grade_items.itemtype = 'manual') AND grade_items.courseid = :course_id GROUP BY grade_items.itemmodule";
        $records = $DB->get_records_sql($query, array("user_id" => $user_id, "course_id" => $course_id));
        $ratios = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = $record->itemmodule != "manual" && !empty($record->itemmodule) ? "'".get_string('modulename', "mod_".$record->itemmodule)."'" : "'".get_string('manual_grade', "block_moodlean")."'" ;
            $ratios[] = $record->avggraderatio;
        }
        $student = $DB->get_record('user', array("id" => $user_id));
        return array(
            'label' => $student->firstname . " " . $student->lastname,
            'values' => $ratios,
            'labels' => $labels
        );
    }
}