<br/>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>32)); ?>
    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>254)); ?>

    <?php echo $form->dropDownListRow($model, 'access_level', UserRole::model()->getLvlAccess(), array(
        'class'=>'span5'
    )); ?>


	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			//'type'=>'primary',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' => $this->listUrl('role'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
