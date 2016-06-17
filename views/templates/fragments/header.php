<link rel="stylesheet" type="text/css" href="styles/header.css">
<?php
require_once('classes/UrlGenerator.php');

if (isset($student)) {
    $PAGE->navbar->add(get_string('pluginname', "block_moodlean"));
    $PAGE->navbar->add(get_string('see_by_student', 'block_moodlean'), new moodle_url(UrlGenerator::to_student_selection()));
    $PAGE->navbar->add($student->firstname . " " . $student->lastname);
    $img_src = $CFG->wwwroot . "/blocks/moodlean/img/student-icon.png";
    $rotule = $student->firstname . " " . $student->lastname;
} elseif (isset($group)) {
    $PAGE->navbar->add(get_string('pluginname', "block_moodlean"));
    $PAGE->navbar->add(get_string('see_by_group', 'block_moodlean'), new moodle_url(UrlGenerator::to_group_selection()));
    $PAGE->navbar->add($group->name);
    $img_src = $CFG->wwwroot . "/blocks/moodlean/img/group-icon.png";
    $rotule = $group->name;
} else {
    $PAGE->navbar->add(get_string('pluginname', "block_moodlean"));
    $PAGE->navbar->add(get_string('see_by_class', 'block_moodlean'), new moodle_url(UrlGenerator::to_class_analytics()));
    $img_src = $CFG->wwwroot . "/blocks/moodlean/img/class-icon.png";
    $rotule = get_string('see_by_class', "block_moodlean");
}
echo $OUTPUT->header();
?>

<div class="dashboard-header">
    <h2><?php echo $course->fullname ?></h2>
    <h3><img src="<?php echo $img_src; ?>"><?php echo $rotule; ?></h3>
</div>

