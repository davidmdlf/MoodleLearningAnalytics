<link rel="stylesheet" type="text/css" href="styles/header.css">
<?php
require_once('classes/UrlGenerator.php');

if (isset($student_ids)) {
    $PAGE->navbar->add(get_string('pluginname', "block_moodlean"));
    $PAGE->navbar->add(get_string('see_by_student', 'block_moodlean'), new moodle_url(UrlGenerator::to_student_selection()));
    $PAGE->navbar->add(get_string('compare', 'block_moodlean'), new moodle_url(UrlGenerator::to_student_comparation_selection()));
    $img_src = $CFG->wwwroot . "/blocks/moodlean/img/student-icon.png";
    $rotule = get_string('compare', 'block_moodlean');
} else {
    $PAGE->navbar->add(get_string('pluginname', "block_moodlean"));
    $PAGE->navbar->add(get_string('see_by_group', 'block_moodlean'), new moodle_url(UrlGenerator::to_group_selection()));
    $PAGE->navbar->add(get_string('compare', 'block_moodlean'), new moodle_url(UrlGenerator::to_group_comparation_selection()));
    $img_src = $CFG->wwwroot . "/blocks/moodlean/img/group-icon.png";
    $rotule = get_string('compare', 'block_moodlean');
}
echo $OUTPUT->header();
?>

<div class="dashboard-header">
    <h2><?php echo $course->fullname ?></h2>
    <h3><img src="<?php echo $img_src; ?>"><?php echo get_string('compare', 'block_moodlean'); ?></h3>
</div>

