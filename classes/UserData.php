<?php
/**
 * UserData class with static methods to retrieve learning analytics for students
 *
 * Author: David Miguel de la Fuente
 */
require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot .'/grade/querylib.php');

class UserData {

    static function get_all_course_grades($user_id, $course_id){
        global $DB;
        $query = "SELECT grade_items.id, ((grade_grades.finalgrade - grade_items.grademin)/(grade_items.grademax - grade_items.grademin))*10 as grade, grade_items.itemname FROM {grade_items} grade_items JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid WHERE grade_grades.userid = :user_id AND grade_items.itemtype = 'mod' AND grade_items.courseid = :course_id ";
        $records = $DB->get_records_sql($query, array("user_id" => $user_id, "course_id" => $course_id));
        $grades = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = "'".$record->itemname."'";
            $grades[] = $record->grade;
        }
        return array(
            'grades' => $grades,
            'labels' => $labels
        );
    }

    static function get_performance_radar($user_id, $course_id){
        global $DB;
        $query = "SELECT grade_items.itemmodule, (AVG(grade_grades.finalgrade)/AVG(grade_items.grademax)) AS avggraderatio FROM {grade_items} grade_items JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid WHERE grade_grades.userid = :user_id AND grade_items.itemtype = 'mod' AND grade_items.courseid = :course_id GROUP BY grade_items.itemmodule";
        $records = $DB->get_records_sql($query, array("user_id" => $user_id, "course_id" => $course_id));
        $ratios = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = "'".$record->itemmodule."'";
            $ratios[] = $record->avggraderatio;
        }
        return array(
            'ratios' => $ratios,
            'labels' => $labels
        );
    }
}