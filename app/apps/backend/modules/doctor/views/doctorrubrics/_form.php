

<?php
/**
 * @var $form TbActiveForm
 * @var $model DoctorRubrics
 */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'doctor-rubrics-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350)); ?>
<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>250)); ?>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>250)); ?>


<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');


echo $form->labelEx($model,'description_short');

$this->widget('ImperaviRedactorWidget', array(
		'model' => $model,
		'attribute' => 'description_short',

		'options' => array(
				'lang' => 'ru',
				'cleanOnPaste'=>false,
				'cleanStyleOnEnter'=>true,
				'cleanSpaces'=>false,
				'replaceDivs' => false,
				'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
				'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
				'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
		),
		'plugins' => array(
				'fullscreen' => array(
						'js' => array('fullscreen.js',),
				),
				'video' => array(
						'js' => array('video.js',),
				),
				'table' => array(
						'js' => array('table.js',),
				),
				'fontcolor' => array(
						'js' => array('fontcolor.js',),
				),
				'fontfamily' => array(
						'js' => array('fontfamily.js',),
				),
				'fontsize' => array(
						'js' => array('fontsize.js',),
				),
				'filemanager' => array(
						'js' => array('filemanager.js',),
				),
				'myphotogalery' => array(
						'js' => array('myphotogalery.js',),
				),
				'imagemanager' => array(
						'js' => array('imagemanager.js',),
				),
		),
));


echo $form->labelEx($model,'description');

$this->widget('ImperaviRedactorWidget', array(
		'model' => $model,
		'attribute' => 'description',

		'options' => array(
				'lang' => 'ru',
				'cleanOnPaste'=>false,
				'cleanStyleOnEnter'=>true,
				'cleanSpaces'=>false,
				'replaceDivs' => false,
				'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
				'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
				'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
		),
		'plugins' => array(
				'fullscreen' => array(
						'js' => array('fullscreen.js',),
				),
				'video' => array(
						'js' => array('video.js',),
				),
				'table' => array(
						'js' => array('table.js',),
				),
				'fontcolor' => array(
						'js' => array('fontcolor.js',),
				),
				'fontfamily' => array(
						'js' => array('fontfamily.js',),
				),
				'fontsize' => array(
						'js' => array('fontsize.js',),
				),
				'filemanager' => array(
						'js' => array('filemanager.js',),
				),
				'myphotogalery' => array(
						'js' => array('myphotogalery.js',),
				),
				'imagemanager' => array(
						'js' => array('imagemanager.js',),
				),
		),
));


?>

<?php
echo $form->dropDownListRow($model,'status',array(0=>'Не активно', 1=>'Активно'),
    array('class'=>'span5'));
?>


<?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>350));; ?>

<?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5')); ?>
<?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5')); ?>



	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>



