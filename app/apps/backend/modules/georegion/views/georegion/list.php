
<legend><?php echo Yii::t("Bootstrap", "LIST.GeoRegion" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = GeoRegion::model()->attributeLabels();



$this->widget('backendfilterWidget', array(
    'listId' => 'geo-region-grid',
    'model' => $model,
    'columns'=>array(


            
            array(
            'country_id',
            'select',
            'listData' => CHtml::listData( GeoCountry::model()->findAll( array('order'=>'name_ru') ), 'id', 'name_ru'),
            'htmlOptions'=>array('class'=>'span5')
        ),

        /*
            array(
            'name_ru',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'name_en',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'sort',
            'htmlOptions'=>array('class'=>'span5')
        ),
        */
    ),
));

echo '<a class="btn" href="/admin/georegion/georegion/create">Добавить</a>';

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'geo-region-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$model->with("country")->search(),
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
            'header'=> $labels["country_id"],
            'name' => 'country_id',
            'value' => '$data->country ? $data->country->name_ru : ""',
            'filter' => CHtml::listData( GeoCountry::model()->findAll( array('order'=>'name_ru') ), 'id', 'name_ru'),
        ),
		
	
            array(
            'header'=> $labels["name_ru"],
            'name'=> "name_ru",
        ),
        
/*
            array(
            'header'=> $labels["name_en"],
            'name'=> "name_en",
        ),
        
	
            array(
            'header'=> $labels["sort"],
            'name'=> "sort",
        ),
*/
/*
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{link}',
            'buttons' => array(
                'link' => array(
                    'label'=> 'GeoCity',
                    'options'=>array(
                        //'class' => 'btn btn-small update',
                        'target' => '_blank',
                    ),
                    'url' => 'CHtml::normalizeUrl(array("index", "GeoCity[region_id]" => $data->id))', //'Yii::app()->controller->itemUrl( "/georegion/GeoCity/index?GeoCity[region_id]=" . $data->id )',
                ),
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),
*/

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("georegion/update/id/" . $data->id)',
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
