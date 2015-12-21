

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-elements-discount-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow($model, "element_id",
    CHtml::listData( CatalogElements::model()->findAll(), "id", "name"),
    array('class'=>'span5', "empty" => "Не выбран")
); ?>


<?php echo $form->textFieldRow($model,'count',array('class'=>'span5','maxlength'=>11));; ?>

<?php echo $form->textFieldRow($model,'values',array('class'=>'span5','maxlength'=>10));; ?>

<?php echo $form->dropDownListRow($model, "type", CatalogElementsDiscount::model()->getType(),array('class'=>'span5')); ?>

<?php echo $form->dropDownListRow($model, "user_role_id", CatalogElementsDiscount::model()->getUserRole(),array('class'=>'span5')); ?>

<?php
echo $form->dropDownListRow($model,'status',CatalogElementsDiscount::model()->getStatuslist(),
    array('class'=>'span5'));
?>

<?php /* echo $form->DatePickerRow($model, 'created_at', array(
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
			));; */ ?>

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

<script>
    $(document).on('keyup','#CatalogElementsDiscount_values',function(){
        var str = $(this).val();
        var new_val = str.replace(/[^.0-9]/gim,'');
        $(this).val(new_val);
    });
</script>
