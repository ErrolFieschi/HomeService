<?php

class Form {
    private $data;

    public function __construct($data = array()) {
        $this->data = $data;
    }

    private function getValue($index) {
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function input($placeholder, $name, $type, $class, $onkeyup, $id) {
        return '<input class="' . $class . '" type="' . $type . '" 
            name="' . $name . '" placeholder="' . $placeholder . '" 
            value="' . $this->getValue($name) . '" onkeyup="' . $onkeyup . '" id="' . $id . '">';
    }

    public function textArea($name, $class, $id, $row) {
        return '<textarea name="' . $name . '" placeholder="' . $name . '" 
        value="' . $this->getValue($name) .'" class= "'.  $class . '" id= "'.  $id .'" rows="' . $row . '"></textarea>';
    }

    public function text($name, $class, $id, $row, $val) {
        return '<textarea name="' . $name . '" 
        value="' . $this->getValue($name) .'" class= "'.  $class . '" id= "'.  $id .'" rows="' . $row . '">' . $val . '</textarea>';
    }

    public function select($label, $name, $options, $class, $onBlur, $id)
    {
        $j = 0;
        $tmp = [];

        $tmp[0] = '<label>' . $label . '  </label>';
        $tmp[1] = '<select class="' . $class . '"  id="' . $label . '" name="' . $name . '">';

        for ($i = 2;  $i < count($options) + 2; $i++)
        {
            $tmp[$i] = '<option value="' . $options[$j] . '">' . $options[$j] . '</option>';
            $j++;
        }

        $tmp[$i] = '</select>';

        return join('',$tmp);
    }



    public function submit($class) {
        return '<button class="' . $class . '" type="submit">Valider</button>';
    }

    public function submitHref($class,$link) {
        return '<button class="' . $class . '" href="' . $link . '" type="submit">Valider</button>';
    }
}

