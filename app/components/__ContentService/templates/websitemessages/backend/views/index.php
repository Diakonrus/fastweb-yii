
<legend><?php echo Yii::t("Bootstrap", "LIST.WebsiteMessages" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = WebsiteMessages::model()->attributeLabels();


echo '<a href="/admin/websitemessages/websitemessages/create" style="margin-bottom: 20px" class="btn">Создать</a>';


echo '
    <ul class="nav nav-tabs" role="tablist">
        <li role="webmessages"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Входящие</a></li>
        <li role="webmessages" class="active"><a href="#outbox" aria-controls="outbox" role="tab" data-toggle="tab">Отправленные</a></li>
    </ul>
';

echo '
    <div class="tab-content" id="tabListData">
        <div role="tabpanel" class="tab-pane active" id="outbox">
';

//Исходящие
$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'website-in-messages-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$provider['outbox'],
    'filter'=>$model,


	'columns'=>array(


	
            array(
            'header'=> $labels["id"],
            'name'=> "id",
        ),
        
	
            array(
            'header'=> $labels["author_id"],
            'name' => 'author_id',
            'value' => '$data->author ? $data->author->username : ""',
            'filter' => CHtml::listData( User::model()->findAll( array('order'=>'username') ), 'id', 'username'),
        ),
/*
        array(
            'header'=> $labels["recipient_id"],
            'name' => 'recipient_id',
            'value' => '$data->recipient ? $data->recipient->username : ""',
            'filter' => CHtml::listData( User::model()->findAll( array('order'=>'username') ), 'id', 'username'),
        ),
*/
            array(
            'header'=> $labels["title"],
            'name'=> "title",
        ),

        array(
            'header'=> $labels["body"],
            'name'=> "body",
        ),
	
            array(
            'header'=> $labels["created_at"],
            'name'=> "created_at",
            'value'=>'date("d-m-Y H:m:s", strtotime($data->created_at))',
        ),
        
        /*
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
        */
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',

            'buttons' => array(
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
));

echo '
      </div>
        <div role="tabpanel" class="tab-pane" id="inbox">
';


//Входящие
$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'id'=>'website-out-messages-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'dataProvider'=>$provider['inbox'],
    'filter'=>$model,


    'columns'=>array(



        array(
            'header'=> $labels["id"],
            'name'=> "id",
        ),


        array(
            'header'=> $labels["author_id"],
            'name' => 'author_id',
            'value' => '$data->author ? $data->author->username : ""',
            'filter' => CHtml::listData( User::model()->findAll( array('order'=>'username') ), 'id', 'username'),
        ),
        /*
                array(
                    'header'=> $labels["recipient_id"],
                    'name' => 'recipient_id',
                    'value' => '$data->recipient ? $data->recipient->username : ""',
                    'filter' => CHtml::listData( User::model()->findAll( array('order'=>'username') ), 'id', 'username'),
                ),
        */
        array(
            'header'=> $labels["title"],
            'name'=> "title",
        ),

        array(
            'header'=> $labels["body"],
            'name'=> "body",
        ),

        array(
            'header'=> $labels["created_at"],
            'name'=> "created_at",
            'value'=>'date("d-m-Y H:m:s", strtotime($data->created_at))',
        ),

        /*
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
        */
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> 'Ответить',
                    'url'=>'CHtml::normalizeUrl(array("answer", "id" => $data->id))', //'Yii::app()->controller->itemUrl("emailmessages/update/id/" . $data->id)',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
    ),
));

echo '
        </div>
    </div>
';
?>
