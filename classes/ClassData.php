<?php
/**
 * GroupData class with static methods to retrieve learning analytics for student groups
 *
 * Author: David Miguel de la Fuente
 *
 */

require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot .'/grade/querylib.php');

class ClassData {

    static function get_all_course_grades($course_id){
        global $DB;
        $query = "SELECT AVG(((grade_grades.finalgrade - grade_items.grademin)/(grade_items.grademax - grade_items.grademin))*10) as grade, grade_items.itemname
        FROM {grade_items} grade_items
        JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid
        WHERE (grade_items.itemtype = 'mod' OR grade_items.itemtype = 'manual') AND grade_items.courseid = :course_id
        GROUP BY itemname";
        $records = $DB->get_records_sql($query, array("course_id" => $course_id, "courseid" => $course_id));
        $grades = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = "'".$record->itemname."'";
            $grades[] = round($record->grade, 2);
        }
        return array(
            'label' => get_string('full_class', 'block_moodlean'),
            'values' => $grades,
            'labels' => $labels
        );
    }


    static function get_performance_radar($course_id){
        global $DB;
        $query = "SELECT grade_items.itemmodule, (AVG(grade_grades.finalgrade)/AVG(grade_items.grademax)) as avggraderatio, grade_items.itemname
        FROM {grade_items} grade_items
        JOIN {grade_grades} grade_grades ON grade_items.id = grade_grades.itemid
        WHERE (grade_items.itemtype = 'mod' OR grade_items.itemtype = 'manual') AND grade_items.courseid = :course_id
        GROUP BY grade_items.itemmodule";
        $records = $DB->get_records_sql($query, array("course_id" => $course_id, "courseid" => $course_id));
        $ratios = array();
        $labels = array();
        foreach($records as $record){
            $labels[] = $record->itemmodule != "manual" && !empty($record->itemmodule) ? "'".get_string('modulename', "mod_".$record->itemmodule)."'" : "'".get_string('manual_grade', "block_moodlean")."'" ;
            $ratios[] = round($record->avggraderatio, 2);
        }
        return array(
            'label' => get_string('full_class', 'block_moodlean'),
            'values' => $ratios,
            'labels' => $labels
        );
    }
}