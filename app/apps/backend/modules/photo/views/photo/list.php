
<legend><?php echo Yii::t("Bootstrap", "LIST.Photoalbum" ) ?></legend>

<select name="PhotoElements[parent_id]" id="PhotoElements_parent" class="span5">

    <?php echo '<option value="0">Все</option>'; ?>
    <? if (!empty($catalog)) : ?>
        <? foreach ($catalog as $category) : ?>
            <option value="<?=$category['id'] ?>"
                <?=isset($_GET['PhotoElements']) &&  (int)$_GET['PhotoElements']['parent_id']== $category['id']? 'selected="selected"' : ''?> >
                <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']), $category['name']?>
            </option>
        <? endforeach; ?>
    <? endif;?>

</select>

<?php

$assetsDir = Yii::app()->basePath;
$labels = PhotoElements::model()->attributeLabels();


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'photoalbum-grid',
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
            'header'=> 'Картинка',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/photo/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image )) {
                    $url_img = '/../uploads/filestorage/photo/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image;
                }
                return '<img src="'.$url_img.'" style="width:80px" />';
            },
            'filter' =>'',
        ),

        array(
            'header'=> $labels["name"],
            'name'=> "name",
        ),

        array(
            'header'=> $labels["parent_id"],
            'name'=> "parent_id",
            'value'=>'$data->parent->name',
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
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("photoalbum/update/id/" . $data->id)',
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
<? if (!empty($parent_id)) : ?>
	<input type="file" name="file_upload" id="file_upload" />
<? endif;?>


<div id="ajax_loader" style="display: none;"><img width="40px;" style="position:absolute; margin-top:10px; margin-left:-40px;" src="/images/admin/ajaxloader.gif"></div>
<div class="buttons">
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create"> Добавить фото в альбом</a>
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

    $(document).on('change', '#PhotoElements_parent', function(){
        var param = $(this).val();
        var url = '/admin/photo/photo/index';
        if (param!='0'){ url += '?PhotoElements[parent_id]='+param; }
        location.href = url;
    });
</script>