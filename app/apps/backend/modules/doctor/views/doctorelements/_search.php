<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->dropDownListRow($model, "parent_id",
                        CHtml::listData( DoctorRubrics::model()->findAll(), "id", "title"),
                        array("empty" => "Не выбран")
                    ); ?>

	<?php echo echo $form->textFieldRow($model,'order_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350));; ?>

	<?php echo echo $form->textFieldRow($model,'anonse',array('class'=>'span5','maxlength'=>350));; ?>

	<?php echo echo $form->redactorRow($model, 'brieftext', array(
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

	<?php echo echo $form->redactorRow($model, 'description', array(
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

	<?php echo echo $form->textFieldRow($model,'image',array('class'=>'span5','maxlength'=>5));; ?>

	<?php echo echo $form->textFieldRow($model,'status',array('class'=>'span5'));; ?>

	<?php echo echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>350));; ?>

	<?php echo echo $form->redactorRow($model, 'meta_keywords', array(
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

	<?php echo echo $form->redactorRow($model, 'meta_description', array(
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
