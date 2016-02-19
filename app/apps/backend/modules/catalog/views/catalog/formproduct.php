<style>
    #CatalogElements_parent option {
        max-width: 400px;
    }
</style>

<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
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
    <div class="control-group">
        <label class="control-label required" for="CatalogElements_name">
            Категория
            <span class="required">*</span>
        </label>
        <div class="controls">
            <select name="CatalogElements[parent_id]" id="CatalogElements_parent_id" class="span5">

                <?php echo '<option value="'.$root->id.'">/</option>'; ?>
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


    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>
    <?php //echo $form->textFieldRow($model,'page_name',array('class'=>'span5','maxlength'=>150));; ?>
    <?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>150));; ?>
    <?php //echo $form->textFieldRow($model,'qty',array('class'=>'span5','maxlength'=>150));; ?>
    <?php // echo $form->textFieldRow($model,'prod',array('class'=>'span5','maxlength'=>150));; ?>


</div>


<div class="price_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Стоимость</span></a>
</div>

<div id="price_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>150));; ?>
</div>
<div id="price_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'price_old',array('class'=>'span5','maxlength'=>150));; ?>
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


    ?>
</div>


<div class="settings_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки</span></a>
</div>

<div id="settings_block" style="margin-top: 10px; padding: 10px;">
<?php /*
    <?php if (!$model->isNewRecord) { ?>
        <div class="control-group">
            <label class="control-label" for="CatalogElements_lastupdate">Обновлено</label>
            <div class="controls">
                <?=(date("H:i:s d-m-Y", strtotime($model->lastupdate)));?>
            </div>
        </div>
    <?php } ?>
*/?>

    <div class="control-group">
        <?=CHtml::activeLabel($model,'status');?>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[status]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->status==0){echo 'selected';} ?> >Ожидание</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->status==1){echo 'selected';} ?> >Активно</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <?=CHtml::activeLabel($model,'primary');?>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[primary]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->primary==0){echo 'selected';} ?> >Нет</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->primary==1){echo 'selected';} ?> >Да</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <?=CHtml::activeLabel($model,'shares');?>
        <div class="controls">
            <select class="inputselect span5" name="CatalogElements[shares]"  style="font-weight: bold;">
                <option style="color: red;" value="0"  <?php if (!$model->isNewRecord && $model->shares==0){echo 'selected';} ?> >Нет</option>
                <option style="color: darkgreen;" value="1" <?php if (!$model->isNewRecord && $model->shares==1){echo 'selected';} ?> >Да</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="CatalogElements_status">Картинка</label>
        <div class="controls">
            <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
                //Проверяем файл, если нет картинки - ставим заглушку
                $url_img = "/images/nophoto_100_100.jpg";
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/elements/admin-'.$model->id.'.'.$model->image )) {
                    $url_img = '/../uploads/filestorage/catalog/elements/admin-'.$model->id.'.'.$model->image;
                }
                echo '<a href="/../uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
            } ?>
            <br>
            <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
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


