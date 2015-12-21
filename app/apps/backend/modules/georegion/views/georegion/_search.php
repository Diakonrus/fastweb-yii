<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->textFieldRow($model,'id',array('class'=>'span5'));; ?>

	<?php echo echo $form->dropDownListRow($model, "country_id",
                        CHtml::listData( GeoCountry::model()->findAll(), "id", "title"),
                        array("empty" => "Не выбран")
                    ); ?>

	<?php echo echo $form->textFieldRow($model,'name_ru',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'name_en',array('class'=>'span5','maxlength'=>50));; ?>

	<?php echo echo $form->textFieldRow($model,'sort',array('class'=>'span5'));; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
