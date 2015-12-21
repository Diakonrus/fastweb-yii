<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>150));; ?>

	<?php echo echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>250));; ?>

	<?php echo echo $form->textFieldRow($model,'type_module',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'status',array('class'=>'span5'));; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
