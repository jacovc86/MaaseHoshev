<?php

class FormBuilder {
    public $labels = array();
    public $inputs = array();
    public $output = '';
    public function FormBuilder($action,$attr) {
        $this->output .= form_open($action,$attr);
    }
    public function add_input($label,$id,$class,$name,$attr) {
        array_push($this->labels,$label);
        array_push($this->inputs,array_merge(array('id'=>$id,'name'=>$name,'class'=>$class),$attr));
    }
    public function output($submit) {
        foreach($this->inputs as $i->$input) {
            $this->output .= form_label($this->labels[$i]);
            $this->output .= form_input($input);
        }
        $this->output .= form_submit($submit);
        $this->output .= form_close();
        return $this->output;
    }
}

?>