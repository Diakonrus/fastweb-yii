
<legend><?php echo Yii::t("Bootstrap", "LIST.ArticleRubrics" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = ArticleRubrics::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'id'=>'pages-grid',
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
            'header'=> 'Картинка раздела',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/article/rubrics/admin-'.$dataProvider->id.'.'.$dataProvider->image )) {
                    $url_img = '/../uploads/filestorage/article/rubrics/admin-'.$dataProvider->id.'.'.$dataProvider->image;
                }
                return '<img src="'.$url_img.'" style="width:80px" />';
            },
            'filter' =>'',
        ),

        array(
            'header'=> $labels["name"],
            'type'=>'raw',
            'value' =>  function($data){
                $return = '';
                //Если это level = 2 - вывожу выделеным черным шрифтом
                if ($data->level == 2){
                    $return = '<b>'.$data->name.'</b>';
                } else {
                    //подчиненная категория - вывожу со смещением относительно родительской
                    $repeat_prefix = ($data->level==3)?$data->level:($data->level + 1);
                    $return = str_repeat('&nbsp&nbsp', $repeat_prefix).$data->name;
                }
                return $return;
            },
            'filter' =>'',
        ),



        array(
            'header'=> $labels["url"],
            'name'=> "url",
        ),

        array(
            'header'=> 'Позиций',
            'type'=>'raw',
            'value' =>  function($data){
                $count = ArticleRubrics::getCountElement($data->id);
                return '
                    <a href="/admin/article/articleelements/index?ArticleElements[parent_id]='.$data->id.'">
                        <b>'.$count.'</b>
                    </a>
                ';
            },
            'filter' =>'',
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
            'template' => '{move_up}  {move_down}  {update}  {delete}',

            'buttons' => array(
                'move_up' => array(
                    'label'=>'',
                    'visible'=>'($row==0 || !$data->prev()->find() )?false:true',
                    'url'=>'"/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/move?id=$data->id&move=1"',
                    'options'=>array(
                        'class'=>'icon-arrow-up',
                        'data-original-title'=>'Переместить выше',
                    ),
                ),
                'move_down' => array(
                    'label'=>'',
                    'visible'=>'(($row+2)==ArticleRubrics::model()->count() || !$data->next()->find())?false:true',
                    'url'=>'"/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/move?id=$data->id&move=2"',
                    'options'=>array(
                        'class'=>'icon-arrow-down',
                        'data-original-title'=>'Переместить ниже',
                    ),
                ),
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("newsgroup/update/id/" . $data->id)',
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
));


?>
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