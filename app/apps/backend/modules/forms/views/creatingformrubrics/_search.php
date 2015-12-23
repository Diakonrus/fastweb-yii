<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>250));; ?>

	<?php echo echo $form->textFieldRow($model,'subject_recipient',array('class'=>'span5','maxlength'=>350));; ?>

	<?php echo echo $form->textFieldRow($model,'email_recipient',array('class'=>'span5','maxlength'=>350));; ?>

	<?php echo echo $form->textFieldRow($model,'complete_mess',array('class'=>'span5','maxlength'=>450));; ?>

	<?php echo echo $form->textFieldRow($model,'status',array('class'=>'span5'));; ?>

	<?php echo echo $form->DatePickerRow($model, 'creating_at', array(
				'options'=>array(
					'autoclose' => true,
					//'showAnim'=>'fold',
					'type' => 'Component',
					'format'=>'yyyy-mm-dd',
				),
				'htmlOptions'=>array(
					//'value'=> strlen($model->creating_at) > 0 ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->creating_at) : '',
					//'class'=>'span2'
				),
			));; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
