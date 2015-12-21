
<legend><?php echo Yii::t("Bootstrap", "LIST.BeforeAfterRubrics" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = BeforeAfterRubrics::model()->attributeLabels();


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'before-after-rubrics-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'dataProvider'=>$provider,
    'filter'=>$model,
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
            'header'=> $labels["url"],
            'name'=> "url",
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
            'header'=> 'Позиций',
            'type'=>'raw',
            'value' =>  function($data){
                $count = BeforeAfterRubrics::getCountTree($data->left_key,$data->right_key);
                return '
                    <a href="/admin/beforeafter/beforeafterrubrics/index?id='.$data->id.'">
                        <b>'.$count.'</b>
                    </a>
                ';
            },
            'filter' =>'',
        ),
        

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{move_up}  {move_down}  {update}  {delete}',

            'buttons' => array(
                'move_up' => array(
                    'label'=>'',
                    'visible'=>'($row==0)?false:true',
                    'url'=>'"/admin/beforeafter/beforeafterrubrics/move?id=$data->id&move=1"',
                    'options'=>array(
                        'class'=>'icon-arrow-up',
                        'data-original-title'=>'Переместить выше',
                    ),
                ),
                'move_down' => array(
                    'label'=>'',
                    'visible'=>'(($row+1)==BeforeAfterRubrics::model()->count("level=$data->level"))?false:true',
                    'url'=>'"/admin/beforeafter/beforeafterrubrics/move?id=$data->id&move=2"',
                    'options'=>array(
                        'class'=>'icon-arrow-down',
                        'data-original-title'=>'Переместить ниже',
                    ),
                ),
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("beforeafterrubrics/update/id/" . $data->id)',
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
    <a class="btn btn-primary" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create?id=<?=(isset($_GET['id']))?(int)$_GET['id']:0;?>" style="margin-top:14px; float:left; margin-left:15px"> Добавить новую категорию</a>
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
</script>