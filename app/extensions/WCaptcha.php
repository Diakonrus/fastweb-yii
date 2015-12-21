<?php

class WCaptcha extends CCaptcha {

    public $model;
    public $attribute;
    public $showRefreshButton = true;
    public $required_string = null;

    public function init(){
        return $this;
    }

    public function run() {

        $this->registerClientScript();

        // html
        //echo CHtml::openTag('div', array('class'=>'capcha'));
        //echo CHtml::openTag('div', array('class'=>'capcha_img_block'));
        //parent::run();
        //echo CHtml::closeTag('div');

        //input
        //$this->controller->beginWidget('WInputRow', array('model'=>$this->model, 'attribute'=>$this->attribute, 'required_string' => $this->required_string));
        //echo CHtml::activeTextField($this->model, $this->attribute);
        //$this->controller->endWidget();

        //echo CHtml::closeTag('div');
    }

    //public function renderImage() {
        //echo CHtml::openTag('div', array('class'=>'capcha_img', 'style'=>'background: url("/images/capcha.png")', 'id'=>get_class($this->model).'_'.$this->attribute.'_container'));
        //parent::renderImage();
        //echo CHtml::closeTag('div');

    //}

    /**
     * Класс для обновляющего капчу элемента
     */
    public function refreshClass(){
        return 'refresh-captcha-' . $this->attribute;
    }

    public function registerClientScript() {

        $id = $this->imageOptions['id'];
        $url = $this->getController()->createUrl($this->captchaAction, array(CCaptchaAction::REFRESH_GET_VAR=>true) );

/*
        $js="";

        //if ($this->showRefreshButton) {

            // reserve a place in the registered script so that any enclosing button js code appears after the captcha js
            $cs->registerScript('Yii.CCaptcha#'.$id, '// dummy');

            //$label=$this->buttonLabel===null ? Yii::t('yii','Get a new code') : $this->buttonLabel;

            //$options = $this->buttonOptions;

            //if(isset($options['id'])){
            //    $buttonID = $options['id'];
            //} else {
                $buttonID = $options['id'] = $id.'_button';
            //}

            $html=CHtml::openTag('div', array('class'=>'capcha_img_other'));
            $html.=CHtml::link( $label, $url, $options);
            $html.=CHtml::closeTag('div');

            $js =" jQuery('#".get_class($this->model).'_'.$this->attribute.'_container'."').after(".CJSON::encode($html).");";

            $selector = "#$buttonID";
        //}

        //if($this->clickableImage){
            //$selector = isset($selector) ? "$selector, #$id" : "#$id";
        //}

        //if(!isset($selector)){
        //    return;
        //}
*/

        $refreshClass = $this->refreshClass();

        // refresh button
        $js = '$(".' . $refreshClass . '").click( function(){
            jQuery.ajax({
                url: ' . json_encode($url) . ',
                dataType: "json",
                cache: false,
                success: function(data) {
                    jQuery("#' . $id . '").attr("src", data["url"]);
                    jQuery("body").data(" ' . $this->captchaAction . '.hash", [data["hash1"], data["hash2"]]);
                }
            });

            return false;
        });';

        Yii::app()->clientScript->registerScript('Yii.CCaptcha#' . $id, $js);
    }



}
