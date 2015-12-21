<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'parent_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'before_photo',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'after_photo',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'briftext',array('class'=>'span5','maxlength'=>550));; ?>

	<?php echo echo $form->redactorRow($model, 'before_text', array(
				'editorOptions' => array(
                    'imageUpload' => CHtml::normalizeUrl(array('imageUpload')),
                    'imageUploadParam' => 'image',
                    'autoresize' => false,
                    'plugins' => array('extelf'),
                ),
                'htmlOptions' => array(
                   'style' => 'height: 150px'
                )
            ));; ?>

	<?php echo echo $form->redactorRow($model, 'after_text', array(
				'editorOptions' => array(
                    'imageUpload' => CHtml::normalizeUrl(array('imageUpload')),
                    'imageUploadParam' => 'image',
                    'autoresize' => false,
                    'plugins' => array('extelf'),
                ),
                'htmlOptions' => array(
                   'style' => 'height: 150px'
                )
            ));; ?>

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
