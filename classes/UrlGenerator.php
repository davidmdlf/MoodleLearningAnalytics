<?php

/**
 * Created by PhpStorm.
 * User: David
 * Date: 17/06/2016
 * Time: 20:22
 */

class UrlGenerator{

    const URL_BASE = "/blocks/moodlean";

    static function to_student_selection(){
        global $CFG, $COURSE, $USER;
        $params = array(
            "course_id" => $COURSE->id,
            "user_id" => $USER->id,
            "type" => "student"
        );
        return $CFG->wwwroot.self::URL_BASE.'/index.php?' . http_build_query($params, '', '&');;
    }

    static function to_group_selection(){
        global $CFG, $COURSE, $USER;
        $params = array(
            "course_id" => $COURSE->id,
            "user_id" => $USER->id,
            "type" => "group"
        );
        return $CFG->wwwroot.self::URL_BASE.'/index.php?' . http_build_query($params, '', '&');;
    }


    static function to_student_analytics($student_id){
        global $CFG, $COURSE;
        $params = array(
            "course_id" => $COURSE->id,
            "student_id" => $student_id,
            "type" => "student"
        );
        return $CFG->wwwroot.self::URL_BASE.'/analytics.php?' . http_build_query($params, '', '&');;
    }


    static function to_group_analytics($group_id){
        global $CFG, $COURSE;
        $params = array(
            "course_id" => $COURSE->id,
            "group_id" => $group_id,
            "type" => "group"
        );
        return $CFG->wwwroot.self::URL_BASE.'/analytics.php?' . http_build_query($params, '', '&');;
    }

    static function to_class_analytics(){
        global $CFG, $COURSE, $USER;
        $params = array(
            "course_id" => $COURSE->id,
            "user_id" => $USER->id,
            "type" => "class"
        );
        return $CFG->wwwroot.self::URL_BASE.'/analytics.php?' . http_build_query($params, '', '&');;
    }
}