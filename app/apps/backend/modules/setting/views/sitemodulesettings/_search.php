<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'site_module_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'version',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_small',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_small_crop',array('class'=>'span5','maxlength'=>12));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_medium',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_medium_crop',array('class'=>'span5','maxlength'=>12));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_medium2',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_medium2_crop',array('class'=>'span5','maxlength'=>12));; ?>

	<?php echo echo $form->textFieldRow($model,'r_cover_quality',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'r_small_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'r_medium_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'r_medium2_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'elements_page_admin',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'watermark',array('class'=>'span5','maxlength'=>255));; ?>

	<?php echo echo $form->textFieldRow($model,'watermark_pos',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'watermark_type',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'watermark_transp',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'watermark_color',array('class'=>'span5','maxlength'=>80));; ?>

	<?php echo echo $form->textFieldRow($model,'watermask_font',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo echo $form->textFieldRow($model,'watermask_fontsize',array('class'=>'span5','maxlength'=>20));; ?>

	<?php echo echo $form->textFieldRow($model,'status',array('class'=>'span5'));; ?>

	<?php echo echo $form->DatePickerRow($model, 'created_at', array(
				'options'=>array(
					'autoclose' => true,
					//'showAnim'=>'fold',
					'type' => 'Component',
					'format'=>'yyyy-mm-dd',
				),
				'htmlOptions'=>array(
					//'value'=> strlen($model->created_at) > 0 ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->created_at) : '',
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
