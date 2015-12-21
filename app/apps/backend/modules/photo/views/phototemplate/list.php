
<legend><?php echo Yii::t("Bootstrap", "LIST.PhotoTemplate" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = PhotoTemplate::model()->attributeLabels();



$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'photo-template-grid',
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
            'header'=> $labels["active"],
            'name'=> "active",
            'value'=>'$data->active==1?"Активен":"Не активет"'
        ),
        

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("phototemplate/update/id/" . $data->id)',
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

<?php echo '<a class="btn btn-primar" href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/create">Добавить</a>'; ?>
