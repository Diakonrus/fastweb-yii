

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'site-module-settings-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<div class="block_data" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
	<span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки модуля "<?=$model->siteModuleName->name;?>"</span>
</div>
<div class="control-group">

	<?php echo $form->hiddenField($model,'site_module_id',array('class'=>'span5','maxlength'=>11));; ?>
	<?php echo $form->hiddenField($model,'version',array('class'=>'span5','maxlength'=>10));; ?>
	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->dropDownListRow($model, 'status', array(0=>'Отключен', 1=>'Активно'), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'elements_page_admin',array('class'=>'span5'));; ?>

	<?php
		if ($model->siteModuleName->id == 4){
			//Для каталога выводим правило формирования URL
			echo $form->dropDownListRow($model, 'url_form', SiteModuleSettings::model()->getFormURL(), array('class'=>'span5'));
		}
	?>

	<?php echo $form->dropDownListRow($model, 'type_list', SiteModuleSettings::model()->getTypeList(), array('class'=>'span5')); ?>

</div>


<div class="block_data" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
	<span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки изображений рубрик модуля</span>
</div>
<div class="control-group">

	<?php echo $form->dropDownListRow($model, 'r_cover_small_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'r_cover_small',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'r_small_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->dropDownListRow($model, 'r_cover_medium_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'r_cover_medium',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'r_medium_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->dropDownListRow($model, 'r_cover_large_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'r_cover_large',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'r_large_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->textFieldRow($model,'r_cover_quality',array('class'=>'span5'));; ?>
</div>

<div class="block_data" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
	<span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки изображений элементов модуля</span>
</div>
<div class="control-group">

	<?php echo $form->dropDownListRow($model, 'e_cover_small_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'e_cover_small',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'e_small_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->dropDownListRow($model, 'e_cover_medium_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'e_cover_medium',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'e_medium_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->dropDownListRow($model, 'e_cover_large_crop',SiteModuleSettings::model()->getResizeMethod(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'e_cover_large',array('class'=>'span5','maxlength'=>50));; ?>
	<?php echo $form->textFieldRow($model,'e_large_color',array('class'=>'span5','maxlength'=>10));; ?>

	<?php echo $form->textFieldRow($model,'e_cover_quality',array('class'=>'span5'));; ?>
</div>



<div class="block_data" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
	<span style="color: #fff; margin-left: 10px; font-weight: bold;">Водяные знаки</span>
</div>
<div class="control-group">



	<div class="control-group">
		<label class="control-label" for="SiteModuleSettings_image_watermark">Картинка</label>
		<div class="controls">
			<?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
				$folder = SiteModuleSettings::model()->getFolderModelName($model->site_module_id);
				$base_url_img = '/../uploads/filestorage/'.$folder.'/';
				//Проверяем файл, если нет картинки - ставим заглушку
				$url_img = "/images/nophoto_100_100.jpg";
				if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.'watermark.png' )) {
					$url_img = $base_url_img.'watermark.png';
				}
				echo '<img src="'.$url_img.'" style="max-width:150px;">';
			} ?>
			<br>
			<?php echo CHtml::activeFileField($model, 'image_watermark', array('style'=>'cursor: pointer;') ); ?>
		</div>
	</div>



<?php //echo $form->textFieldRow($model,'watermark',array('class'=>'span5','maxlength'=>255));; ?>
<?php echo $form->dropDownListRow($model, 'watermark_type',array(0=>'Отсутствует',1=>'Изображение PNG'), array('class'=>'span5')); ?>
<?php echo $form->dropDownListRow($model, 'watermark_pos',SiteModuleSettings::model()->getWatermarkMethod(), array('class'=>'span5')); ?>

<?php //echo $form->textFieldRow($model,'watermark_transp',array('class'=>'span5','maxlength'=>10));; ?>
<?php //echo $form->textFieldRow($model,'watermark_color',array('class'=>'span5','maxlength'=>80));; ?>
<?php //echo $form->textFieldRow($model,'watermask_font',array('class'=>'span5','maxlength'=>10));; ?>
<?php //echo $form->textFieldRow($model,'watermask_fontsize',array('class'=>'span5','maxlength'=>20));; ?>

</div>

<div class="block_data" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
	<span style="color: #fff; margin-left: 10px; font-weight: bold;">Пересборка иллюстраций</span>
</div>
<div class="control-group">

	<div class="control-group">
		<label class="control-label" for="CatalogWatermark_img_small">
			Изменить размер и наложить водяные знаки (если указан `Тип водяного знака`.<BR><span style="color:red;">Внимание! Операция может занять длительное время.</span>
		</label>
		<div class="controls">
			<?php echo CHtml::dropDownList('runn_recomplite', null,
				array('0' => 'Нет', '1' => 'Запустить для рубрики', '2' => 'Запустить для элементов', '3' => 'Запустить для всех изображений модуля'), array('class'=>'span5'));
			?>
			<br>
			<div id="runn_recomplite_alert"></div>
		</div>
	</div>

</div>



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
