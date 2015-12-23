<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'feedback-status-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
)); ?>

	<p class="help-block"><?php //echo Yii::t('Bootstrap', 'PHRASE.FIELDS_REQUIRED') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>240)); ?>

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
            'url' => $this->listUrl('admin'),
        )); ?>

	</div>

<?php $this->endWidget(); ?>


