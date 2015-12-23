

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'before-after-elements-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>


<div class="control-group">
    <label class="control-label required" for="BeforeAfterElements_after_parent_id"><?=$form->labelEx($model,'parent_id');?></label>
    <div class="controls">
        <select name="BeforeAfterElements[parent_id]" id="BeforeAfterElements_parent_id" class="span5">

            <?php //echo '<option value="'.$root->id.'">/</option>'; ?>
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




<div class="control-group">
    <label class="control-label required" for="BeforeAfterElements_before_photo_file"><?=$form->labelEx($model,'before_photo');?></label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/beforeafter/elements/';
        ?>
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.'before_'.$model->id.'.'.$model->before_photo )) {
                $url_img = $base_url_img.'small-before_'.$model->id.'.'.$model->before_photo;
            }
            echo '<a href="'.$base_url_img.'before_'.$model->id.'.'.$model->before_photo.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'before_photo_file', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label required" for="BeforeAfterElements_after_photo_file"><?=$form->labelEx($model,'after_photo');?></label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/beforeafter/elements/';
        ?>
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.'after_'.$model->id.'.'.$model->after_photo )) {
                $url_img = $base_url_img.'small-after_'.$model->id.'.'.$model->after_photo;
            }
            echo '<a href="'.$base_url_img.'after_'.$model->id.'.'.$model->after_photo.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'after_photo_file', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>

<?php
Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');


echo $form->labelEx($model,'briftext');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'briftext',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>true,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
    ),
));


echo $form->labelEx($model,'before_text');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'before_text',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>true,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
    ),
));

echo $form->labelEx($model,'after_text');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'after_text',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>true,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
    ),
));
?>

<?php echo $form->dropDownListRow($model,'status',array(1=>'Активно', 0=>'Не активно'),array('class'=>'span5'));?>

<?php echo $form->dropDownListRow($model, 'on_main', array(0 => 'Нет', 1 => 'Да'),array('class'=>'span5'));?>

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
