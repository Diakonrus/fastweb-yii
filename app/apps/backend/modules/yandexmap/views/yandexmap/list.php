<legend><?php echo Yii::t("Bootstrap", "LIST.YandexMap" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = YandexMap::model()->attributeLabels();



$this->widget('backendfilterWidget', array(
    'listId' => 'yandex-map-grid',
    'model' => $model,
    'columns'=>array(


            
            array(
            'coord',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'description',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
    ),
));

echo '<a href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/create" class="btn">Добавить</a>';

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'yandex-map-grid',
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
            'header'=> $labels["coord"],
            'name'=> "coord",
        ),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("yandexmap/update/id/" . $data->id)',
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

<?php
    $arrayCoords = array();
    $i = 0;
    foreach ( $coords as $data ){
        $arrayCoords[$i]['coords'] = $data->coord;
        $arrayCoords[$i]['description'] = $data->description;
        ++$i;
    }
?>


<?php
$startCoord = ($coords[0])?($coords[0]->coord):null;
$this->widget('ext.ymap.Ymap', array(
        'startCoord' => $startCoord,
        'coordsData' => $arrayCoords,
        'mapX'=>800,
        'mapY'=>600,

    )
);

?>
