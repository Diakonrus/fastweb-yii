
<legend><?php echo Yii::t("Bootstrap", "LIST.GeoCountry" ) ?></legend>
<a class="btn" href="/admin/geocountry/geocountry/create">Добавить</a>
<?php

$assetsDir = Yii::app()->basePath;
$labels = GeoCountry::model()->attributeLabels();


/*
$this->widget('backendfilterWidget', array(
    'listId' => 'geo-country-grid',
    'model' => $model,
    'columns'=>array(


            
            array(
            'name_ru',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'name_en',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'code',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'sort',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
    ),
));
*/

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'geo-country-grid',
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
            'header'=> $labels["name_ru"],
            'name'=> "name_ru",
        ),
        
/*
            array(
            'header'=> $labels["name_en"],
            'name'=> "name_en",
        ),
        
	
            array(
            'header'=> $labels["code"],
            'name'=> "code",
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
                    'url' => 'CHtml::normalizeUrl(array("index", "GeoCity[country_id]" => $data->id))', //'Yii::app()->controller->itemUrl( "/geocountry/GeoCity/index?GeoCity[country_id]=" . $data->id )',
                ),
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),
*/
/*
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{link}',
            'buttons' => array(
                'link' => array(
                    'label'=> 'Регион',
                    'options'=>array(
                        //'class' => 'btn btn-small update',
                        'target' => '_blank',
                    ),
                    'url' => 'CHtml::normalizeUrl(array("index", "GeoRegion[country_id]" => $data->id))', //'Yii::app()->controller->itemUrl( "/geocountry/GeoRegion/index?GeoRegion[country_id]=" . $data->id )',
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
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("geocountry/update/id/" . $data->id)',
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
