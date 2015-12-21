<?php $this->widget('JSearchWidget', array(
    'formOptions'=>array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'juser-filter',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
    ),
)) ?>        
