<legend>Список общих характеристик</legend>
<style>
    .content_table td {
        border-bottom: 1px solid #e6edec;
        border-left-style: hidden;
        border-right-style: hidden;
        padding: 6px;
        vertical-align: middle;
    }
</style>

<?php
    $assetsDir = Yii::app()->basePath;
    $labels = CatalogChars::model()->attributeLabels();
?>


<!-- Modal -->
<div id="addcharsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addcharsModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Добавить новую предопределенную характеристику</h3>
    </div>
    <div class="modal-body">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'chars-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
            'type' => 'horizontal',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        )); ?>

        <?php echo $form->textFieldRow($model,'name',array('class'=>'span2','maxlength'=>150));; ?>
        <?php echo $form->dropDownListRow($model,'type_scale',CatalogChars::model()->getTypeScale(), array('class'=>'span2')); ?>
        <?php echo $form->dropDownListRow($model,'parent_id', $catalog, array('class'=>'span2', 'encode'=>false)); ?>
        <?php echo $form->dropDownListRow($model,'inherits',array('0'=>'Нет','1'=>'Да'), array('class'=>'span2')); ?>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions' => array('class' => 'applyBtn', 'style' => 'margin-right: 20px'),
            'label'=>'Сохранить',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>


<?php


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'id'=>'chars-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'htmlOptions' => array('class' => 'content_table'),

    'dataProvider'=>$provider,
    'filter'=>$model,

    'columns'=>array(

        'name',

        array(
            'header'=> $labels["type_scale"],
            'name'=> "type_scale",
            'type'=>'raw',
            'value' =>  function($data){
                return CatalogChars::model()->getTypeScale($data->type_scale);
            },
            'filter' =>'',
        ),


        array(
            'header'=> 'Назначено',
            'type'=>'raw',
            'value' =>  function($data){

            },
            'filter' =>'',
        ),


        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete_chars}',

            'buttons' => array(
                'delete_chars' => array(
                    'label'=>'Удалить',
                    'imageUrl'=>'/images/admin/ico_delete.gif',
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/deletechars", array("id"=>$data->id))',
                ),
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
    ),
));

?>
<div id="ajax_loader" style="display: none;"><img width="40px;" style="position:absolute; margin-top:10px; margin-left:-40px;" src="/images/admin/ajaxloader.gif"></div>
<div class="buttons">
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="#" onclick="$('#addcharsModal').modal('show');return false;"> Добавить новое свойство</a>
    <a class="btn btn-success" style="float:left; margin-left:15px; margin-top:14px" href="javascript: saveForm();">Сохранить изменения</a>
</div>

<script>
    //Меняем статус
    $(document).on('click', '.on-off-product', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:6, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });

    //Сохраняет данные со страницы списка
    function saveForm(){
        var arrOrder = [];  //Порядок
        $('.order_id').each(function(){
            var val = $(this).data('id')+'|'+$(this).val();
            arrOrder.push( val );
        });

        $('#ajax_loader').show();
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:7, order:arrOrder},
            success: function(data) {
                $("#chars-grid").load(document.location.href+" #chars-grid");
                $('#ajax_loader').hide();
                alert('Данные сохранены');
            }
        });
    }
</script>