<legend>Список профилей</legend>
<style>
    #pages-grid thead th {
        background-color: #3689d8;
        border: 1px solid #ccc;
        color: #fff;
        font-weight: bold;
        padding: 5px;
        text-align: center;
    }
</style>
<?php

$assetsDir = Yii::app()->basePath;
$labels = News::model()->attributeLabels();

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
            'header'=> $labels["name"],
            'name'=> "name",
        ),

        array(
            'header'=> $labels["brieftext"],
            'name'=> "brieftext",
        ),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{uploaddata}  {update}  {delete}',

            'buttons' => array(
                'uploaddata' => array(
                    'label'=> 'Загрузить',
                    'url'=>'Yii::app()->createUrl("/loadxml/loadxml/uploaddata", array("id"=>$data->id))',
                    'imageUrl'=>'/images/admin/uploaddata.png',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    )
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
