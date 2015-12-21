<legend><?php echo 'Настройки модуля "Каталог"'; ?></legend>


<div class="image_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <span style="color: #fff; margin-left: 10px; font-weight: bold;">Список общих характеристик</span>
</div>
<div class="control-group">
    <label class="control-label" for="catalog_chars">
        Перейти к списку общих характеристик
    </label>
    <div class="controls">
        <a href="/admin/catalog/catalog/sharechars" class="btn">Перейти</a>
    </div>
</div>


<?php

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'category-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>


<?php echo $form->errorSummary($model); ?>

<div class="image_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
        <span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройка размера картинок</span>
</div>
<div class="control-group">
    <label class="control-label" for="CatalogWatermark_img_small">
        Размер превью картинки (префикс small)
        (введите ширину (x) в пикселях, высота (y) будет подобрана автоматически для сохранения пропорций)
    </label>
    <div class="controls">
        <?php echo $form->textField($model,'img_small',array('class'=>'span2','maxlength'=>150)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="CatalogWatermark_img_medium">
        Размер картинки (префикс medium)
        (введите ширину (x) в пикселях, высота (y) будет подобрана автоматически для сохранения пропорций)
    </label>
    <div class="controls">
        <?php echo $form->textField($model,'img_medium',array('class'=>'span2','maxlength'=>150)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="CatalogWatermark_img_medium2">
        Размер картинки (префикс medium2)
        (введите ширину (x) в пикселях, высота (y) будет подобрана автоматически для сохранения пропорций)
    </label>
    <div class="controls">
        <?php echo $form->textField($model,'img_medium2',array('class'=>'span2','maxlength'=>150)); ?>
    </div>
</div>



<div class="watermark_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
        <span style="color: #fff; margin-left: 10px; font-weight: bold;">Водяной знак</span>
</div>
<div class="control-group">
    <label class="control-label" >Картинка</label>
    <div class="controls">
        <?php

        $filepatch = '/../uploads/filestorage/catalog/watermark.png';
        $filepatch = YiiBase::getPathOfAlias('webroot').$filepatch;
        if (file_exists($filepatch)){
            echo '
            <img src="/uploads/filestorage/catalog/watermark.png" width=300px />
            ';
        } else { echo '<img src="/images/nophoto_100_100.jpg">'; }
        ?>
        </BR>
        <?php echo CHtml::activeFileField($model, 'image_watermark', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="CatalogWatermark_watermark_pos">Расположение водяного знака</label>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'watermark_pos', CatalogSettings::model()->getWatermarkPos()); ?>
    </div>
</div>


<div class="image_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <span style="color: #fff; margin-left: 10px; font-weight: bold;">Пересборка иллюстраций</span>
</div>

<div class="control-group">
    <label class="control-label" for="CatalogWatermark_img_small">
        Выполнить процесс для каталога:
    </label>
    <div class="controls">
        <select name="runn_recomplite_catalog" id="runn_recomplite_catalog" class="span5">
            <option value="0">Для всего каталога</option>
            <? if (!empty($catalog)) : ?>
                <? foreach ($catalog as $category) : ?>
                    <option value="<?=$category['id'] ?>">
                        <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']), $category['name']?>
                    </option>
                <? endforeach; ?>
            <? endif;?>
        </select>
    </div>
</div>


<div class="control-group">
    <label class="control-label" for="CatalogWatermark_img_small">
        Изменить размер и наложить водяные знаки (для запуска процесса, выбирите `Запустить`)
    </label>
    <div class="controls">
        <?php echo CHtml::dropDownList('runn_recomplite', null,
            array('0' => 'Нет', '1' => 'Запустить'));
        ?>
        <br>
        <div id="runn_recomplite_alert"></div>
    </div>
</div>



<div class="form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px', 'class'=>'okbtn'),
        'label'=> Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
    )); ?>


</div>
<div id="ajax_loader" style="display: none;">
    <img src="/images/ajaxloader.gif" width=150 style="position:absolute; margin-top:-130px; margin-left:150px;" />
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).on('click', '#runn_recomplite', function(){
        if ( $('#runn_recomplite').val()==1 ){
            $('#runn_recomplite_alert').empty()
            $('#runn_recomplite_alert').append('<span style="color:red">Процесс пересоздания картинок может занять длительное время!</span>');
        }
        else {
            $('#runn_recomplite_alert').empty();
        }
    });
    $(document).on('click', '.okbtn', function(){
        $('#ajax_loader').show();
    });
</script>