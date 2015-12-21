<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'website-messages-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>


<!-- Получатель -->
<?php
echo $form->dropDownListRow($model, 'recipient_id', WebsiteMessages::model()->getUsergroup(), array(
    'class'=>'span5',
)); ?>


<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>350)); ?>
<?php
Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'body',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/imageUpload'),
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

?>
<?php //echo $form->textFieldRow($model,'send_date',array('class'=>'span5'));; ?>

	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>

		<?php /* $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		));  */ ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>
