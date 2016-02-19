

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'baners-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<div class="control-group">
	<label class="control-label required" for="BanersElements_name">
		Категория
		<span class="required">*</span>
	</label>
	<div class="controls">
		<select name="BanersElements[parent_id]" id="BanersElements_parent_id" class="span5">

			<? if (!empty($catalog)) : ?>
				<? foreach ($catalog as $category) : ?>
					<option value="<?=$category->id ?>"
						<?=!$model->isNewRecord && $model->parent_id == $category['id']? 'selected="selected"' : ''?>>
						<?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->level), $category->name?>
					</option>
				<? endforeach; ?>
			<? endif;?>

		</select>

	</div>
</div>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>450));; ?>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>450));; ?>

<div class="control-group">
    <label class="control-label" for="BanersalbumElements_imagefile">Картинка</label>
    <div class="controls">
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/baners/elements/admin-'.$model->id.'.'.$model->image )) {
                $url_img = '/../uploads/filestorage/baners/elements/admin-'.$model->id.'.'.$model->image;
            }
            echo '<a href="/../uploads/filestorage/baners/elements/'.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>


<?php echo $form->dropDownListRow($model,'status',
    array('1' => 'Активно', '0' => 'Не активно'));
?>

	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>

		<?php
        /*
        $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		));
        */
        ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>
