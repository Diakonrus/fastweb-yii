<?php

class googlemapWidget extends CWidget{

    public $lat;
    public $lng;
    public $zoom;
    public $model;
    public $form;

    public function init(){
        Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', CClientScript::POS_HEAD);
    }

    public function run(){

        $this->render('googlemapWidget', array(
            'id' => $this->id,
            'model' => $this->model,
            'form' => $this->form,
            'lng'=>$this->lng,
            'lat'=>$this->lat,
            'zoom' => $this->zoom
        ));
    }
}