<legend>Список свойств объекта <?=$object_name;?></legend>
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
            'header'=> $labels["scale"],
            'name'=> "scale",
            'type'=>'raw',
            'value' =>  function($data){
                $val = $data->scale;

                $scale_val = array();
                //разбираем значение в scale если type_scale == 2 или 3
                $tmp_scale_val = explode("|", $val);
                if (is_array($tmp_scale_val)){
                    $scale_val = array_filter($tmp_scale_val);
                    if ($data->type_scale == 3){
                        $val = '';
                        foreach ($scale_val as $v){
                            $val .= '<div style="float:left; margin-left:10px; width: 30px; height: 30px; background: '.$v.'"></div>';
                        }
                    }
                    if ($data->type_scale == 2){
                        $val = '<ul>';
                        foreach ($scale_val as $v){
                            $val .= '<li>'.$v.'</li>';
                        }
                        $val .= '</ul>';
                    }
                }
                return $val;
            },
            'filter' =>'',
        ),

        array(
            'name'=>'order_id',
            'value'=>'CHtml::activeTextField($data, "[$row]order_id", array("class"=>"order_id", "data-id"=>$data->id))' ,
            'type'=>'raw',
        ),


        array(
            'header'=> 'Статус',
            'name'=> "status",
            'type'=>'raw',
            'value' =>  function($data){
                return '
                    <a href="#" class="on-off-product" data-id="'.$data->id.'" data-status="'.$data->status.'">
                        <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'.(($data->status==1)?'green':'red').'"></div>
                    </a>
                ';
            },
            'filter' =>'',
        ),




        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update_chars}  {delete_chars}',

            'buttons' => array(
                'update_chars' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-pencil',
                        'title'=>'Редактировать',
                    ),
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/updatechars", array("id"=>$data->id, "type_parent"=>'.$type_parent.'))',
                ),
                'delete_chars' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-trash',
                        'title'=>'Удалить',
                    ),
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
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/createchars?id=<?=$_GET['id'];?>&type_parent=<?=$type_parent;?>"> Добавить новое свойство</a>
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