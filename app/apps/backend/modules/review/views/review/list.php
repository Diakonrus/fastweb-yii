
<legend><?php echo Yii::t("Bootstrap", "LIST.Review" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = ReviewElements::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'review-elements-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'htmlOptions' => array('class' => 'content_table'),

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
            'header'=> $labels["parent_id"],
            'name' => 'parent_id',
            'value' => '$data->parent ? $data->parent->name : ""',
            'filter' => CHtml::listData( ReviewRubrics::model()->findAll( array('order'=>'name') ), 'id', 'name'),
        ),
		
	
    		array(
            'header'=> $labels["author_id"],
            'name' => 'author_id',
            'value' => '$data->author ? $data->author->name : ""',
            'filter' => CHtml::listData( ReviewAuthor::model()->findAll( array('order'=>'name') ), 'id', 'name'),
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
            'header'=> $labels["review_data"],
            'name'=> "review_data",
        ),


        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("reviewelements/update/id/" . $data->id)',
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
    <a class="btn btn-primary" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" style="margin-top:14px; float:left; margin-left:15px"> Добавить новый отзыв</a>
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
