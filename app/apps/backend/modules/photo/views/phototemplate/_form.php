

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'photo-template-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350));; ?>

<?php echo $form->textAreaRow($model,'val',array('class'=>'span5','rows'=>6, 'cols'=>50)); ?>

<i>При создании шаблона вывода фотогалереи не забудьте вставить переменные:</i><br>
%url_to_full_image% - ссылка на полное изображение картинки в фотогалереи<BR>
%url_to_small_image% - ссылка на маленькое изображение картинки в фотогалереи<BR>

<?php echo $form->dropDownListRow($model, 'active', array('0'=>'Не активен', '1'=>'Активен'), array('class'=>'span5'));;  ?>


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
