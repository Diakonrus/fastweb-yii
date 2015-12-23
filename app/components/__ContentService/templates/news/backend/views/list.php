
<legend><?php echo Yii::t("Bootstrap", "LIST.News" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = News::model()->attributeLabels();





echo '<a href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/create" class="btn">Добавить</a>';

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
            'header'=> $labels["id"],
            'name'=> "id",
        ),
        
	
            array(
            'header'=> $labels["name"],
            'name'=> "name",
        ),

	
            array(
            'header'=> $labels["brieftext"],
            'name'=> "brieftext",
        ),


            array(
                'header'=> $labels["status"],
                'name'=> "status",
                'value' => 'News::model()->getDownliststatus($data->status)',
                'filter' => News::model()->getStatuslist(),
        ),

        

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
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
