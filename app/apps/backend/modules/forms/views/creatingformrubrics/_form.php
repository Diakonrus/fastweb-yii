

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'creating-form-rubrics-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>250));; ?>
<?php echo $form->textFieldRow($model,'subject_recipient',array('class'=>'span5','maxlength'=>350));; ?>
<?php echo $form->textFieldRow($model,'email_recipient',array('class'=>'span5','maxlength'=>350));; ?>
<?php echo $form->textFieldRow($model,'complete_mess',array('class'=>'span5','maxlength'=>450));; ?>

<?php echo $form->textAreaRow($model,'form_template',array('class'=>'span5', 'style'=>'min-height:200px;')); ?>
<?php
/*
Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

echo $form->label($model,'form_template');
$this->widget('ImperaviRedactorWidget', array(
	'model' => $model,
	'attribute' => 'form_template',

	'options' => array(
		'lang' => 'ru',
		'imageUpload' => Yii::app()->createAbsoluteUrl('/news/news/imageUpload'),
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
	),
));
*/
?>
<b>Правила создания шаблона:<BR>
Шаблон создается в HTML коде. В месте где должны выводиться поля вставьте код:</b> %feelds_input%

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
