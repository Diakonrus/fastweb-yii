<?php

class DateFilter extends CInputWidget {
	public $form;
    public $range;

	
	public function init() {

	}


    public function run() {
        list($this->name, $this->id) = $this->resolveNameID();

        $this->render('date_filter_form', array(
            'model' => $this->model
        ));
    }

    function getNameWithPostfix($postfix) {
        return substr($this->name, 0, -1).'_'.$postfix.']';
    }

    function getIdWithPostfix($postfix) {
        return $this->id.'_'.$postfix;
    }
}