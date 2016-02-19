
<legend><?php echo Yii::t("Bootstrap", "LIST.Pages" ) ?></legend>


<?php

$assetsDir = Yii::app()->basePath;
$labels = Pages::model()->attributeLabels();


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
            'header'=> $labels["title"],
            'name'=> "title",
            'type'=>'raw',
            'value' => function($data){
                $return = '';
                //Если это level = 2 - вывожу выделеным черным шрифтом
                if ($data->level == 2){
                    $return = '<b>'.$data->title.'</b>';
                } else {
                    //подчиненная категория - вывожу со смещением относительно родительской
                    $repeat_prefix = ($data->level==3)?$data->level:($data->level + 1);
                    $return = str_repeat('&nbsp&nbsp', $repeat_prefix).$data->title;
                }


                return $return;
            },
            //'filter' => array('1' => 'Да', '0' => 'Нет'),
        ),
        /*

            array(
            'header'=> $labels["title"],
            'name'=> "title",
        ),
        */
        
	
            array(
            'header'=> $labels["url"],
            'name'=> "url",
        ),


        array(
            'header'=> $labels["status"],
            'name'=> "status",
            'type'=>'raw',
            'value' =>  function($data){
                return '
                    <a href="#" class="on-off-product" data-id="'.$data->id.'" data-status="'.$data->status.'">
                        <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'.(($data->status==1)?'green':'red').'"></div>
                    </a>
                ';
            },
            'filter' => array('1' => 'Активно', '0' => 'Не активно'),
        ),











        array(
            'header'=> $labels["in_header"],
            'name'=> "in_header",
            'type'=>'raw',
            'value' =>  function($data){
                return '
                    <a href="#" class="on-off-product-header" data-id="'.$data->id.'" data-status="'.$data->in_header.'">
                        <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'.(($data->in_header==1)?'green':'red').'"></div>
                    </a>
                ';
            },
            'filter' => array('1' => 'Активно', '0' => 'Не активно'),
        ),









        array(
            'header'=> $labels["in_footer"],
            'name'=> "in_footer",
            'type'=>'raw',
            'value' =>  function($data){
                return '
                    <a href="#" class="on-off-product-footer" data-id="'.$data->id.'" data-status="'.$data->in_footer.'">
                        <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'.(($data->in_footer==1)?'green':'red').'"></div>
                    </a>
                ';
            },
            'filter' => array('1' => 'Активно', '0' => 'Не активно'),
        ),









        array(
            'header'=> 'Главная страница сайта',
            'name'=> "main_page",
            'type'=>'raw',
            'value' => function($dataProvider){
                $return = 'Нет';
                if ($dataProvider->main_page == 1){
                    $return = '<img src="/../images/admin/icons/star.png" />';
                }
                return $return;
            },
            'filter' => array('1' => 'Да', '0' => 'Нет'),
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
                    'visible'=>'(($row+2)==Pages::model()->count() || !$data->next()->find())?false:true',
                    'url'=>'"/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/move?id=$data->id&move=2"',
                    'options'=>array(
                        'class'=>'icon-arrow-down',
                        'data-original-title'=>'Переместить ниже',
                    ),
                ),
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

<a href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" class="btn">Добавить</a>

<script>
    $(document).on('change', '#changeModule', function(){
        location.href = "/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/index"+(($(this).val().length>0)?("?"+$(this).val()):'');
    } );

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
    
    //Меняем статус
    $(document).on('click', '.on-off-product-footer', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxfooter',
            dataType: "json",
            data: {type:1, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });
	
	//Меняем статус
    $(document).on('click', '.on-off-product-header', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxheader',
            dataType: "json",
            data: {type:1, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });
</script>
