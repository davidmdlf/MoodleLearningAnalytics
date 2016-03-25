<?php
class block_learning_analytics extends block_base
{
    public function init(){
        $this->title = get_string('pluginname', 'block_learning_analytics');
    }

    public function get_content() {

        $this->content         =  new stdClass;
        $this->content->text   = 'Hola Mundo!';
        $this->content->footer = 'Soy el pie';

        return $this->content;
    }
}