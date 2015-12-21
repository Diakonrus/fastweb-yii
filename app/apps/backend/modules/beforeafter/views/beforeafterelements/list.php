
<legend><?php echo Yii::t("Bootstrap", "LIST.BeforeAfterElements" ) ?></legend>

Фильтр:
<select id="BeforeAfterElements_parent_id" class="span5">

    <option value="0">Все</option>
    <? if (!empty($catalog)) : ?>
        <? foreach ($catalog as $category) : ?>
            <option value="<?=$category->id ?>"
                <?=isset($_GET['BeforeAfterElements']) && (int)$_GET['BeforeAfterElements']['parent_id'] == $category['id']? 'selected="selected"' : ''?>>
                <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->level), $category->name?>
            </option>
        <? endforeach; ?>
    <? endif;?>

</select>

<?php

$assetsDir = Yii::app()->basePath;
$labels = BeforeAfterElements::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'before-after-elements-grid',
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
            'header'=> 'Фотографии',
            'type'=>'raw',
            'value' =>  function($data){
                $url_no_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/beforeafter/elements/admin-before_'.$data->id.'.'.$data->before_photo )) {
                    $url_img_before = '/../uploads/filestorage/beforeafter/elements/admin-before_'.$data->id.'.'.$data->before_photo;
                } else { $url_img_before = $url_no_img; }
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/beforeafter/elements/admin-after_'.$data->id.'.'.$data->after_photo )) {
                    $url_img_after = '/../uploads/filestorage/beforeafter/elements/admin-after_'.$data->id.'.'.$data->after_photo;
                } else { $url_img_after = $url_no_img; }
                return '<img src="'.$url_img_before.'" style="width:80px" /><img src="'.$url_img_after.'" style="width:80px" />';
            },
            'filter' =>'',
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
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("beforeafterelements/update/id/" . $data->id)',
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

<table>
    <tr>
        <td><a href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" class="btn">Добавить новый элемент</a></td>
    </tr>
</table>

<script>
    $(document).on('change','#BeforeAfterElements_parent_id', function(){
        var parent = $(this).val();
        var url = '/admin/beforeafter/beforeafterelements';
        if (parent>0){
            url += '?BeforeAfterElements[parent_id]='+parent;
        }

        location.href = url;
    });

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


