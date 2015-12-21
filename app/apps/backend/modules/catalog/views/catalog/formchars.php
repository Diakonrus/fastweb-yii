<style>
    .redactor-editor{
        min-height: 300px;
    }
    .iColorPicker {
        width:60px;
        height:60px;
        margin-right:10px;
    }
    .groupInput {
        margin-right:10px;
    }
    .deleteBlock {
        color: white;
        position:absolute;
        margin-top:-10px;
        margin-left:-20px;
        border-radius:10px;
        background:red;
    }
</style>


<!-- Modal -->
<div id="formModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <div id="formyModalLabel"></div>
    </div>
    <div class="modal-body">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
        <button class="btn btn-primary">Применить</button>
    </div>
</div>



<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'chars-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>
<?php echo $form->errorSummary($model); ?>


<div onclick="$('#main_block').slideToggle(); return false;" class="main_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Основное</span></a>
</div>
<div id="main_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>

    <?php echo $form->dropDownListRow($model,'type_scale',CatalogChars::model()->getTypeScale(), array('class'=>'span5')); ?>

    <div id="scale_row" style="display:none;">
        <?php echo $form->textFieldRow($model,'scale',array('class'=>'span5','maxlength'=>150));; ?>
    </div>

    <div id="group_selector" style="display: none;">
        <?php
        if (!empty($scale_val) && $model->type_scale==2){
            $i = 0;
            ?>
            <?php  foreach($scale_val as $val){ ?>
                <input id="group<?=$i;?>" name="group<?=$i;?>" type="text"  class="groupInput" value="<?=$val;?>" placeholder="Введите значение" /><a href="#" data-type="group" data-id="<?=$i;?>" class="btn-mini deleteBlock">X</a>
            <?php ++$i; } ?>
        <?php  } ?>
        <a class="addNewGroupBtn btn" style="clear: both;" href="#">+</a>
    </div>

    <div id="color_selector" style="display: none;">
        <?php
            if (!empty($scale_val) && $model->type_scale==3){
                $i = 0;
            ?>
            <?php  foreach($scale_val as $val){ ?>
                <input id="mycolor<?=$i;?>" name="mycolor<?=$i;?>" type="text"  class="iColorPicker" value="<?=$val;?>" onclick="var id_a = '#icp_'+$(this).attr('id');  $(id_a).click();" /><a href="#" data-type="mycolor" data-id="<?=$i;?>" class="btn-mini deleteBlock">X</a>
            <?php ++$i; } ?>
        <?php  } else {  ?>
                <input id="mycolor0" class="iColorPicker" type="text" name="mycolor1" style="display: none" />
        <?php } ?>
        <a href="#" class="addNewColorBtn btn" style="clear: both;"  >+</a>
    </div>




</div>

<div onclick="$('#settings_block').slideToggle(); return false;" class="settings_block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#"><span style="color: #fff; margin-left: 10px; font-weight: bold;">Настройки</span></a>
</div>
<div id="settings_block" style="margin-top: 10px; padding: 10px;">
    <?php echo $form->dropDownListRow($model,'status',array('0'=>'Ожидание','1'=>'Активно')); ?>
    <?php echo $form->dropDownListRow($model,'inherits',array('0'=>'Нет','1'=>'Да')); ?>
</div>



<div class="form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('class' => 'applyBtn', 'style' => 'margin-right: 20px'),
        'label'=>'Сохранить',
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'link',
        'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
        'htmlOptions' => array('onclick' => 'history.back()'),
        //'url' =>$this->listUrl('listchars?id='.((!empty($model->parent_id))?$model->parent_id:'')),
    )); ?>

</div>

<?php $this->endWidget(); ?>

<script>
    var count = <?=(count($scale_val));?>;

    $(document).ready(function(){
        $('#CatalogChars_type_scale').click();
    });

    $(document).on('click', '#CatalogChars_type_scale', function(){
        //$('#CatalogChars_scale').val('');
        $('#scale_row').hide();
        $('#color_selector').hide();
        $('#group_selector').hide();
        var type = $(this).val();
        switch (type) {
            case '1':
                //Обычное текстовое значение - вывожу просто поле scale
                $('#scale_row').show();
                break;
            case '2':
                //Групповые значения товара - вывожу форму добавления групп
                $('#group_selector').show();
                break;
            case '3':
                //Цвета товара - вывожу форму добавления цветов
                $('#color_selector').show();
                break;
        }
    });

    //Кнопка - Добавить цвет
    $(document).on('click', '.addNewColorBtn', function () {
        ++count;
        var html = '<input id="mycolor'+count+'" name="mycolor'+count+'" value="#fff" type="text"  class="iColorPicker" onclick="var id_a = \'#icp_\'+$(this).attr(\'id\');  $(id_a).click();" /><a href="#" data-type="mycolor" data-id="'+count+'" class="btn-mini deleteBlock">X</a>';
        html += '<a id="icp_mycolor'+count+'" onclick="iColorShow(\'mycolor'+count+'\',\'icp_mycolor'+count+'\')" style="display:none;" href="javascript:void(null)"> </a>';
        $(this).before(html);
        return false;
    });

    //Кнопка - удалить
    $(document).on('click','.deleteBlock', function(){
        var id = $(this).data('id');
        var type = $(this).data('type');
        $(this).remove();
        $('#'+type+''+id).remove();
        $('#icp_'+type+''+id).remove();
        return false;
    });

    //Кнопка Добавить группу нажали
    $(document).on('click','.addNewGroupBtn', function(){
        ++count;
        var html = '<input id="group'+count+'" name="group'+count+'" class="groupInput"  type="text" placeholder="Введите значение" /><a href="#" data-type="group" data-id="'+count+'" class="btn-mini deleteBlock">X</a>';
        $(this).before(html);
        return false;
    });




    //Нажали кнопку сохранить - если тип цвет или множественный выбор - применяю значение для поля CatalogChars_scale
    $(document).on('click', '.applyBtn', function(){
        var type = $('#CatalogChars_type_scale').val();
        var val_scale = '';

        //Групповое значение или Цвет
        if (type == '2' || type == '3'){
            var class_input = (type == '2')?'.groupInput':'.iColorPicker';
            $(class_input).each(function(){
                var tmp_val = $(this).val();
                if (tmp_val.length!=0) {
                    val_scale += tmp_val+'|';
                }
            });
        }

        if (val_scale.length!=0){
            $('#CatalogChars_scale').val(val_scale);
        }

    });


</script>
