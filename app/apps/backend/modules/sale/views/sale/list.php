
<legend><?php echo Yii::t("Bootstrap", "LIST.Sale" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = Sale::model()->attributeLabels();


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'pages-grid',
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
            'header'=> $labels["name"],
            'name'=> "name",
        ),

	
            array(
            'header'=> $labels["brieftext"],
            'name'=> "brieftext",
        ),

        /*
            array(
                'header'=> $labels["status"],
                'name'=> "status",
                'value' => 'Sale::model()->getDownliststatus($data->status)',
                'filter' => Sale::model()->getStatuslist(),
        ),
        */

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
                'header'=> $labels["primary"],
                'name'=> "primary",
                'value' => 'Sale::model()->getDownliststatus($data->primary)',
                'filter' => Sale::model()->getStatuslist(),
        ),

        

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("pages/update/id/" . $data->id)',
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

<a href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" class="btn">Добавить акцию</a>

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
</script>