<style>
    td {padding-left: 10px;}
</style>

<legend>
    Конструктор профиля
</legend>



<?php
    //1ый шаг
    if(empty($model->ext)){
?>

<div class="load_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <span style="color: #fff; margin-left: 10px; font-weight: bold;">Загрузка файла</span>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'loadfile-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<table>
    <tbody>
    <tr>
        <td>
            Загрузка файла
            <br>
            <small>
                Вы можете загрузить файл
                <b>cvs</b>
                ,
                <b>xlsx</b>
                или
                <b>xml</b>
                для анализа его структуры
            </small>
        </td>
        <td>
            <?php echo CHtml::activeFileField($model, 'testedfile', array('style'=>'cursor: pointer;') ); ?>
        </td>
    </tr>

    <tr>
        <td>
            Разделитель полей в CSV-формате
        </td>
        <td>
            <?=$form->DropDownList($model,'splitter',LoadxmlRubrics::model()->getSplitter()); ?>
        </td>
    </tr>
    </tbody>
</table>
        <b>Важно! Для конструирования профиля используйте небольшой файл содержащий не более 10-20 строк с позициями товров</b>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px'),
        'label'=>'Тестироват файл',
    )); ?>
</div>

<?php $this->endWidget(); ?>

<?php } else {
    //2ой шаг
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'edit-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

    <?php echo $form->errorSummary($model); ?>

<?php if( strcasecmp($model->ext, 'xml') == 0 ){ ?>
    <div class="load_block_url" style="width: 100%; background-color: #3689d8; padding: 5px; margin-bottom: 5px; cursor: pointer;">
        <span style="color: #fff; margin-left: 10px; font-weight: bold;">Выбор элемента</span>
    </div>

    <table>
        <tbody>
        <tr>
            <td>
                Выберите тег, соответствующий одному заливаемому элементу
            </td>
            <td>
                <?=$form->dropDownList($model,"tag",LoadxmlRubrics::model()->getTags($model),array('class'=>'span5'));?>
            </td>
        </tr>
        </tbody>
    </table>

<?php } ?>


<table class="content_table edit_table" style="margin-top: 20px;">
    <thead>
    <tr>
        <th>Действие</th>
        <th>Привязка</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Выберите модуль для привязки профиля</td>
        <td><?=$form->dropDownList($model,"module",LoadxmlRubrics::model()->getModule(),array('class'=>'span5'));?></td>
    </tr>
    <tr>
        <td>Имя профиля</td>
        <td><?=$form->textField($model,'name',array('class'=>'span5'));?></td>
    </tr>
    <tr>
        <td>Описание профиля</td>
        <td><?=$form->textArea($model,'brieftext',array('rows'=>6, 'cols'=>50, 'class'=>'span5'));?></td>
    </tr>
    <tr>
        <td>
            Разделитель полей в CSV-формате
        </td>
        <td>
            <?=$form->DropDownList($model,'splitter',LoadxmlRubrics::model()->getSplitter(),array('class'=>'span5')); ?>
        </td>
    </tr>
    </tbody>
</table>

<?php echo $form->hiddenField($model,'ext',array('type'=>"hidden",'size'=>2,'maxlength'=>2)); ?>
<?php echo $form->hiddenField($model,'url_to_file',array('type'=>"hidden",'size'=>2,'maxlength'=>2)); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px'),
        'label'=>'Сохранить профиль',
    )); ?>
</div>

<?php $this->endWidget(); ?>

<?php } ?>
