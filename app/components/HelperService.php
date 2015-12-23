<?php

class HelperService{

    public function init(){

    }

    public function random($length = 6, $chars = '0123456789') {

        // длинна
        $max = $length;
        $size = strlen($chars) - 1;
        $string = '';

        while ($max--){
            $string .= $chars[rand(0, $size)];
        }

        return $string;
    }
}