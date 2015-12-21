
<legend><?php echo Yii::t("Bootstrap", "LIST.CreatingFormElements" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = CreatingFormElements::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'creating-form-elements-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$model->search(),
    'filter'=>null,
    //'filter'=>$model,
    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

	'columns'=>array(


	
            array(
            'header'=> $labels["id"],
            'name'=> "id",
        ),
        
	
            array(
            'header'=> $labels["parent_id"],
            'name'=> "parent_id",
            'value'=>'$data->parent->name',
        ),
        
	
            array(
            'header'=> $labels["feeld_type"],
            'name'=> "feeld_type",
            'value'=> 'CreatingFormRubrics::model()->getFeeldsTypes($data->feeld_type)',
        ),


        array(
            'header'=> 'Порядок',
            'name'=>'order_id',
            'value' =>  function($data){ return CHtml::textField('order_'.$data->id,$data->order_id, array("class"=>"order", "data-id"=>$data->id, "data-order"=>$data->order_id)); },
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
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("creatingformelements/update/id/" . $data->id)',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
)); ?>


<div class="buttons">
    <a style="float:left;" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" class="btn">Создать поле формы</a>
    <a class="btn btn-success" style="float:left; margin-left:15px;" href="javascript: saveForm();">Сохранить изменения</a>
</div>

<script>
    //Меняем статус
    $(document).on('click', '.on-off-product', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:1, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });
    //Сохраняет данные со страницы списка
    function saveForm(){
        var arrOrder = [];  //Порядок
        $('.order').each(function(){
            var val = $(this).data('id')+'|'+$(this).val();
            arrOrder.push( val );
        });
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:2, order:arrOrder},
            success: function(data) {
                alert('Данные сохранены');
            }
        });
    }
</script>
