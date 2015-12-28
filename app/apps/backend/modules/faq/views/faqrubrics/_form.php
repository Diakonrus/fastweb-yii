<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'faq-rubrics-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<div class="control-group">
    <label class="control-label required" for="CatalogRubrics_name">
        Категория
        <span class="required">*</span>
    </label>
    <div class="controls">
        <select name="FaqRubrics[parent_id]" id="CatalogRubrics_parent_id" class="span5" <?=!$model->isNewRecord?'disabled':'';?>>

            <?php echo '<option value="'.$root->id.'">/</option>'; ?>
            <? if (!empty($categories)) : ?>
                <? foreach ($categories as $category) : ?>
                    <option value="<?=$category->id ?>"
                        <?php
                            if ($model->isNewRecord && isset($_GET['id']) &&  $category->id==(int)$_GET['id']){
                                echo 'selected="selected"';
                            }
                            elseif ($model->parent_id == $category->id){
                                echo 'selected="selected"';
                            }
                        ?>
                        >
                        <?=str_repeat('--', $category->level), $category->name?>
                    </option>
                <? endforeach; ?>
            <? endif;?>

        </select>
    </div>
</div>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350));; ?>
<div class="control-group">
    <label>
        <a style="margin-left:560px;" class="translits_href" href="#">транслит url</a>
    </label>
</div>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>150));; ?>

<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');


echo $form->labelEx($model,'description');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'description',

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
