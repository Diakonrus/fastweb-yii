<style>
    #CatalogElements_parent option {
        max-width: 400px;
    }
</style>

<?php
/* @var $this CatalogController */
/* @var $model CatalogElements */
/* @var $form TbActiveForm */
/* @var $catalog array */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'product-form',
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


    <?php echo $form->dropDownListRow($model,'parent_id', $catalog, array('class'=>'span5', 'encode'=>false)); ?>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>
    <div class="control-group">
        <label>
            <a style="margin-left:560px;" class="translits_href" href="#">транслит url</a>
        </label>
    </div>
    <?php echo $form->textFieldRow($model,'url',array('class'=>'span5', 'maxlength'=>150)); ?>
    <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>250)); ?>
    <?php //echo $form->textFieldRow($model,'qty',array('class'=>'span5','maxlength'=>150)); ?>
    <?php // echo $form->textFieldRow($model,'prod',array('class'=>'span5','maxlength'=>150)); ?>


</div>


<div class="price_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Стоимость</span></a>
</div>

<div id="price_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textFieldRow($model,'article',array('class'=>'span5','maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textFieldRow($model,'price_old',array('class'=>'span5','maxlength'=>150)); ?>
</div>

<div class="body_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Содержание страницы</span></a>
</div>

<div id="body_block" style="margin-top: 10px; padding: 10px;">
    <?php

    Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

    echo CHtml::activeLabel($model,'brieftext');
    $this->widget('ImperaviRedactorWidget', array(
        'model' => $model,
        'attribute' => 'brieftext',

        'options' => array(
            'lang' => 'ru',
            'imageUpload' => Yii::app()->createAbsoluteUrl('/catalog/catalog/imageUpload'),
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
        ),
    ));


    echo CHtml::activeLabel($model,'description');
    $this->widget('ImperaviRedactorWidget', array(
        'model' => $model,
        'attribute' => 'description',

        'options' => array(
            'lang' => 'ru',
            'imageUpload' => Yii::app()->createAbsoluteUrl('/catalog/catalog/imageUpload'),
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
        ),
    ));

    //echo $form->textAreaRow($model, 'code_3d',array('class'=>'span5'));
    ?>
</div>



<div class="main_block_url block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#" data-type="plus"><span style="color: #fff; margin-left: 10px; font-weight: bold;"><img src="/images/admin/icons/plus.gif" style="padding-right: 10px;" />Настройки</span></a>
</div>

<div id="settings_block" style="display: none; margin-top: 10px; padding: 10px;">


    <?php echo $form->dropDownListRow($model, 'status', array(0=>'Ожидание', 1=>'Активно'), array('class'=>'span5')); ?>

    <?php echo $form->dropDownListRow($model, 'primary', array(0=>'Нет', 1=>'Да'), array('class'=>'span5')); ?>

    <?php echo $form->dropDownListRow($model, 'shares', array(0=>'Нет', 1=>'Да'), array('class'=>'span5')); ?>


    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'imagefile'); ?>
        <div class="controls">
            <?php if ($model->isNewRecord || empty($model->image)): ?>
                <?php echo CHtml::image($model->getImageLink('admin', true)); ?>
            <?php else: ?>
                <?php echo CHtml::link(CHtml::image($model->getImageLink('admin', true), $model->id.'.'.$model->image), $model->getImageLink('large', true), array('target'=>'_blank')); ?>
                <?php echo CHtml::link('X', Yii::app()->urlManager->createUrl('/catalog/catalog/deleteimage', array('id'=>$model->id)), array('class'=>'btn-mini deleteBlock')); ?>
            <?php endif; ?>
            <br>
            <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
        </div>
    </div>

<style>
    .deleteBlock {
        background: red none repeat scroll 0 0;
        border-radius: 10px;
        color: white;
        margin-left: -10px;
        margin-top: -10px;
        position: absolute;
    }
</style>

    <div class="control-group">
        <?php echo CHtml::activeLabel($model,'imagefiles'); ?>
        <div class="controls" style="margin-top: 15px">
            <?php if (!$model->isNewRecord): ?>
                <?php foreach (CatalogElementsImages::model()->findAll('elements_id = '.$model->id) as $data): ?>
                    <div style="margin-bottom: 15px;">
                        <?php echo CHtml::link(CHtml::image($data->getImageLink('admin', true), $data->image_name . '.' . $data->image), $data->getImageLink('', true), array('target'=>'_blank')); ?>
                        <?php echo CHtml::link('X', Yii::app()->urlManager->createUrl('/catalog/catalog/deleteimages', array('id'=>$data->id)), array('class'=>'btn-mini deleteBlock')); ?>
                        <span><?php echo $data->image_name . '.' . $data->image; ?></span>
                    </div>
                <?php endforeach; ?>
                <div style="clear: left"></div>
            <?php endif; ?>
            <br>
            <?php echo CHtml::activeFileField($model, "imagefiles[]", array('multiple'=>true)); ?>
        </div>
    </div>





<?php /*
    <div class="control-group">
        <?=CHtml::activeLabel($model,'available');?>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[available]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->available==0){echo 'selected';} ?> >Нет в наличии</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->available==1){echo 'selected';} ?> >Есть в наличии</option>
            </select>
        </div>
    </div>
*/ ?>


</div>

<?php /*
<div class="seo_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">SEO</span></a>
</div>
<div id="seo_block" style="display: none; margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5','maxlength'=>150));; ?>
</div>
*/ ?>

<?php /*
<div class="ymarket_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">YandexMarket</span></a>
</div>
<div id="ymarket_block" style="display: none; margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'model',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textAreaRow($model,'manufcod',array('class'=>'span5','maxlength'=>150)); ?>

    <div class="control-group">
        <?=CHtml::activeLabel($model,'manufcont');?>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[manufcont]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->available==0){echo 'selected';} ?> >Нет гарантии производителя</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->available==1){echo 'selected';} ?> >Есть гарантии производителя</option>
            </select>
        </div>
    </div>

</div>
*/ ?>
<?php /* ?>

<div class="body_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Содержание страницы</span></a>
</div>

<div id="body_block" style="margin-top: 10px; padding: 10px;">
<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'description',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/catalog/catalog/imageUpload'),
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
    ),
));

echo 'Описание (полный текст)';
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'simpletext',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/catalog/catalog/imageUpload'),
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
    ),
));

?>
</div>

<div class="settings_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки</span></a>
</div>

<div id="settings_block" style="margin-top: 10px; padding: 10px;">

    <?php if (!$model->isNewRecord) { ?>
        <div class="control-group">
            <label class="control-label" for="CatalogElements_lastupdate">Обновлено</label>
            <div class="controls">
                <?=(date("H:i:s d-m-Y", strtotime($model->lastupdate)));?>
            </div>
        </div>
    <?php } ?>

    <div class="control-group">
        <label class="control-label" for="CatalogElements_status">Статус</label>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[status]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->status==0){echo 'selected';} ?> >Ожидание</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->status==1){echo 'selected';} ?> >Активно</option>
            </select>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="CatalogElements_menu_rubrics">Меню</label>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[menu_rubrics]" style="font-weight: bold;">
                <option style="color: red;" value="0" <?php if (!$model->isNewRecord && $model->menu_rubrics==0){echo 'selected';} ?> >Ожидание</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->menu_rubrics==1){echo 'selected';} ?> >Активно</option>
            </select>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="CatalogElements_status">Картинка</label>
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
            <!--<input id="image" type="file" name="load_image" style="width: 300px;">-->
            <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
        </div>
    </div>

</div>


<div class="seo_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">SEO</span></a>
</div>
<div id="seo_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5','maxlength'=>150)); ?>
    <?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5','maxlength'=>150));; ?>
</div>


<?php */ ?>

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
        'url' =>$this->listUrl('/catalog/catalog/listelement'),
    )); ?>

</div>

<?php $this->endWidget(); ?>

<script>
    $(document).on('click', '.main_block_url', function(){
        $('#main_block').slideToggle();
        return false;
    });
    $(document).on('click', '.price_block_url', function(){
        $('#price_block').slideToggle();
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
    $(document).on('click', '.ymarket_block_url', function(){
        $('#ymarket_block').slideToggle();
        return false;
    });

    <?php
    /*
        if ( count($catalog)>1000 ){
            echo "$('#CatalogElements_parent').select2({minimumInputLength: 4});";
        }
    */
    ?>
</script>


