
<legend><?php echo Yii::t("Bootstrap", "LIST.EmailMessages" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = EmailMessages::model()->attributeLabels();

echo '<a href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/create" class="btn" style="margin-bottom:20px;">Добавить</a>';

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'email-messages-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$model->with("user")->search(),
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
            'header'=> $labels["id"],
            'name'=> "id",
        ),
        
	
            array(
            'header'=> $labels["user_id"],
            'name' => 'user_id',
            'value' => '$data->user ? $data->user->username : ""',
            'filter' => CHtml::listData( User::model()->findAll( array('order'=>'username') ), 'id', 'username'),
        ),

        array(
            'header'=> $labels["to_email"],
            'name'=> "to_email",
        ),

            array(
            'header'=> $labels["title"],
            'name'=> "title",
        ),
        
	
    		
	
            array(
            'header'=> $labels["status"],
            'name'=> "status",
            'value'=> 'EmailMessages::model()->getDownliststatus($data->status)',
        ),
        
	
            array(
            'header'=> $labels["send_date"],
            'name'=> "send_date",
            'value'=>'date("d-m-Y h:m:s", strtotime($data->send_date))',
        ),
        
	
            array(
            'header'=> $labels["created_at"],
            'name'=> "created_at",
            'value'=>'date("d-m-Y h:m:s", strtotime($data->created_at))',
        ),
        

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("emailmessages/update/id/" . $data->id)',
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
