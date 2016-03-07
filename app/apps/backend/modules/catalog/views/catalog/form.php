<style>
    .redactor-editor{
        min-height: 300px;
    }
</style>
<?php
/* @var $this CatalogController */
/* @var $model CatalogRubrics */
/* @var $form TbActiveForm */
/* @var $categories array */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'category-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="main_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
<a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Основное</span></a>
</div>

<div id="main_block" style="margin-top: 10px; padding: 10px;">


    <?php echo $form->dropDownListRow($model,'parent_id', $categories, array('class'=>'span5', 'encode'=>false, 'disabled'=>(($model->level==1)?(true):(false)) )); ?>
    <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150)); ?>
    <div class="control-group">
        <label>
            <a style="margin-left:560px;" class="translits_href" href="#">транслит url</a>
        </label>
    </div>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>150));; ?>
    <?php

    Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');


    echo $form->labelEx($model,'description_short');

    $this->widget('ImperaviRedactorWidget', array(
        'model' => $model,
        'attribute' => 'description_short',

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
</div>


<div class="settings_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки</span></a>
</div>

<div id="settings_block" style="margin-top: 10px; padding: 10px;">

    <div class="control-group">
        <label class="control-label" for="CatalogRubrics_status">Статус</label>
        <div class="controls">
            <select class="inputselect span5" name="CatalogRubrics[status]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->status==0){echo 'selected';} ?> >Ожидание</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->status==1){echo 'selected';} ?> >Активно</option>
            </select>
        </div>
    </div>

<?php /*
    <div class="control-group">
        <label class="control-label" for="CatalogRubrics_menu_rubrics">Меню</label>
        <div class="controls">
            <select class="inputselect span5" name="CatalogRubrics[menu_rubrics]" style="font-weight: bold;">
                <option style="color: red;" value="0" <?php if (!$model->isNewRecord && $model->menu_rubrics==0){echo 'selected';} ?> >Ожидание</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->menu_rubrics==1){echo 'selected';} ?> >Активно</option>
            </select>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="CatalogRubrics_status">Картинка</label>
        <div class="controls">
            <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
                //Проверяем файл, если нет картинки - ставим заглушку
                $url_img = "/images/nophoto_100_100.jpg";
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/rubrics/admin-'.$model->id.'.'.$model->image )) {
                    $url_img = '/../uploads/filestorage/catalog/rubrics/admin-'.$model->id.'.'.$model->image;
                }
                echo '<a href="/../uploads/filestorage/catalog/rubrics/'.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
            } ?>

            <br>
            <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
        </div>
    </div>
*/ ?>
</div>


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
        'url' =>$this->listUrl('listgroup' . (!empty($id) ? '?id=' . $id : '')),
    )); ?>

</div>

<?php $this->endWidget(); ?>

<script>
    $(document).on('click', '.main_block_url', function(){
        $('#main_block').slideToggle();
        return false;
    });
    $(document).on('click', '.body_block_url', function(){
        $('#body_block').slideToggle();
        return false;
    });
    $(document).on('click', '.settings_block_url', function(){
        $('#settings_block').slideToggle();
        return false;
    });
    $(document).on('click', '.seo_block_url', function(){
        $('#seo_block').slideToggle();
        return false;
    });


</script>