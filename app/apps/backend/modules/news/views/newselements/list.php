
<legend><?php echo Yii::t("Bootstrap", "LIST.NewsElements" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = NewsElements::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'news-elements-grid',
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
            'header'=> 'Картинка',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/news/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image )) {
                    $url_img = '/../uploads/filestorage/news/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image;
                }
                return '<img src="'.$url_img.'" style="width:80px" />';
            },
            'filter' =>'',
        ),

        array(
            'header'=> $labels["parent_id"],
            'name'=> "parent_id",
            'type'=>'raw',
            'value' =>  function($data){
                $parent_name = $data->parent->name;
                if ($data->parent->level == 1){ $parent_name = '/'; }
                return $parent_name;
            },
            'filter' =>'',
        ),
            /*
            array(
            'header'=> $labels["parent_id"],
            'name'=> "parent_id",
            'value' => '$data->parent->name',
        ),
        */


            array(
            'header'=> $labels["name"],
            'name'=> "name",
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
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("newselements/update/id/" . $data->id)',
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
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create"> Добавить новость</a>
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