
<legend><?php echo Yii::t("Bootstrap", "LIST.SiteModuleSettings" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = SiteModuleSettings::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'site-module-settings-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,


	'dataProvider'=>$model->search(),
    'filter'=>null,
    //'filter'=>$model,
    /*
'bulkActions' => array(
    'actionButtons' => $this->bulkRemoveButton(),
    'checkBoxColumnConfig' => array(
        'name' => 'id'
    ),
),
*/

	'columns'=>array(


	
            array(
            'header'=> 'Название модуля',
            'name'=> "Название модуля",
            'value'=> '$data->siteModuleName->name',
        ),

        array(
            'header'=> $labels["site_module_id"],
            'name'=> "site_module_id",
            'value'=> '$data->siteModuleName->url_to_controller',
        ),

        array(
            'header'=> $labels["version"],
            'name'=> "version",
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
            'template' => '{update}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("sitemodulesettings/update/id/" . $data->id)',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
                    ),
                ),
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
)); ?>


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
