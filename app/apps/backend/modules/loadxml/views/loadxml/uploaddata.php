<style>
    td {padding-left: 10px;}
    #LoadxmlRubrics_parent option {
        max-width: 400px;
    }
</style>

<div class="load_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <span style="color: #fff; margin-left: 10px; font-weight: bold;">Заливка файла типа '<?=$model->ext;?>' по профилю '<?=$model->name;?>'</span>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'loadfile-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>
<?php
    if(Yii::app()->user->hasFlash('error')){ echo '<div style="border-radius:5px; background-color: #f2dede; border-color: #eed3d7; color: #b94a48;padding:10px;">'.(Yii::app()->user->getFlash('error')).'</div>'; }
?>
<?php
    if(Yii::app()->user->hasFlash('success')){ echo '<div style="border-radius:5px; background-color: #71da71; border-color: #71da71; color: #000000;padding:10px;">'.(Yii::app()->user->getFlash('success')).'</div>'; }
?>
<table>
    <tbody>
    <tr>
        <td>
            Загрузка файла
            <br>
            <small>
            Загрузите файл импорта в формате <b><?=$model->ext;?></b>
            </small>
        </td>
        <td>
            <?php echo CHtml::activeFileField($model, 'testedfile', array('style'=>'cursor: pointer;') ); ?>
        </td>
    </tr>

    <?php if (!empty($catalog)) { ?>
    <tr>
        <td>
            Заливать в раздел
        </td>
        <td>
            <select name="LoadxmlRubrics[parent_id]" id="LoadxmlRubrics_parent" class="span5">
                <option value="0">Заливать в корень каталога</option>
                <? if (!empty($catalog)) : ?>
                    <? foreach ($catalog as $category) : ?>
                        <option value="<?=$category['id'] ?>" <?php if (isset($_POST['LoadxmlRubrics']['parent_id']) && (int)$_POST['LoadxmlRubrics']['parent_id']==$category['id']){echo 'selected';} ?> >
                            <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']), $category['name']?>
                        </option>
                    <? endforeach; ?>
                <? endif;?>
            </select>
        </td>
    </tr>
    <?php } ?>

    <tr>
        <td>
            Очистить выбранный раздел перед заливкой
            <br>
            <small>все имеющиеся в разделе данные будут стерты</small>
        </td>
        <td>
            <input type="checkbox" value="1" name="LoadxmlRubrics[clearsect]">
        </td>
    </tr>


    </tbody>
</table>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px'),
        'label'=>'Залить файл',
    )); ?>
</div>

<?php $this->endWidget(); ?>

