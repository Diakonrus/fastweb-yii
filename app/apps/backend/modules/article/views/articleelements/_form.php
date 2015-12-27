

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'article-elements-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<div class="control-group">
    <label class="control-label required" for="ArticleElements_parent_id">
        Категория
        <span class="required">*</span>
    </label>
    <div class="controls">
        <select name="ArticleElements[parent_id]" id="ArticleElements_parent_id" class="span5">
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


<?php echo $form->dropDownListRow($model,'primary',
    array('0' => 'Нет', '1' => 'Да'),array('class'=>'span5'));
?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>250));; ?>

<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

echo $form->label($model,'brieftext');
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'brieftext',
    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
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
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
    ),
));

echo $form->label($model,'description');
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'description',
    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
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
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
    ),
));
?>

<div class="control-group">
    <label class="control-label" for="ArticleRubrics_image">Картинка</label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/article/elements/';
        ?>
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.$model->id.'.'.$model->image )) {
                $url_img = $base_url_img.'small-'.$model->id.'.'.$model->image;
            }
            echo '<a href="'.$base_url_img.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>


<?php echo $form->dropDownListRow($model,'status',
    array('1' => 'Активно', '0' => 'Не активно'));
?>

<?php echo $form->DatePickerRow($model, 'maindate', array(
    'options'=>array(
        'autoclose' => true,
        //'showAnim'=>'fold',
        'type' => 'Component',
        'format'=>'yyyy-mm-dd',
    ),
    'htmlOptions'=>array(
    ),
));; ?>

<div class="seo_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">SEO</span></a>
</div>
<div id="seo_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5')); ?>
    <?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5')); ?>
    <?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5')); ?>
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
