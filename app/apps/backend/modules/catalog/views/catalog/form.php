<style>
    .redactor-editor{
        min-height: 300px;
    }
</style>
<?php
/* @var $this StockController */
/* @var $model CatalogRubrics */
/* @var $form CActiveForm */
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
    <div class="control-group">
        <label class="control-label required" for="CatalogRubrics_name">
            Категория
            <span class="required">*</span>
        </label>
        <div class="controls">
            <select name="CatalogRubrics[parent_id]" id="CatalogRubrics_parent_id" class="span5">

                <?php echo '<option value="'.$root->id.'">/</option>'; ?>
                <? if (!empty($categories)) : ?>
                    <? foreach ($categories as $category) : ?>
                        <option value="<?=$category->id ?>"
                            <?=!empty($_POST['parent']) && $_POST['parent']== $category->id || (isset($_GET['id']) && $category->id==(int)$_GET['id'])? 'selected="selected"' : ''?>>
                            <?=str_repeat('-', $category->level), $category->name?>
                        </option>
                    <? endforeach; ?>
                <? endif;?>

            </select>
        </div>
    </div>


<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>
<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>150));; ?>

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
        'url' =>$this->listUrl('listgroup?id='.$_GET['id']),
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