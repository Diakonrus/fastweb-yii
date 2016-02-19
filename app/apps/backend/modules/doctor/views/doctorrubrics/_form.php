

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'doctor-rubrics-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350));; ?>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>250));; ?>


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



