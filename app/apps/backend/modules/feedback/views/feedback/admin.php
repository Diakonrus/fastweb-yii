<legend>Обратная связь</legend>

<?php $this->widget('backendfilterWidget', array(
    'listId' => 'feedback-grid',
    'model' => $model,
    'columns'=>array(
		array(
			'user_ids',
			'user',
			'multiple'=>true
		),
		array(
			'subject_id',
			'select',
			'listData' => CHtml::listData( FeedbackSubject::model()->findAll( array('order'=>'title') ), 'id', 'title'),
			'htmlOptions'=>array('class'=>'span5')
		),
		array(
			'email',
			function ($model, $attribute, $form) {
				return $form->textFieldRow($model, $attribute, array('class'=>'span5'));
			}
		),
        array(
            'created_at',
            'date',
        ),
		array(
			'created_at',
			'date',
            'range'=>true
		),
		array(
			'status_id',
			'select',
			'listData' => CHtml::listData(FeedbackStatus::model()->findAll(array('order'=>'title')),'id','title'),
			'htmlOptions'=>array('class'=>'span5')
		),
    ),
));

    $this->widget('bootstrap.widgets.TbExtendedGridView', array(

    'template' => "{items}\n{pager}",
	'id'=>'feedback-grid',
	'enableHistory' => true,

    //'afterAjaxUpdate'=>'function(id, data){ $("select").each(function(index, element) { new IEDropdown(element); }); }',
	'dataProvider' => $model->search(),
    'filter'=>null,
	//'filter'=>$model,
    'type' => 'bordered striped',

    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

	'columns'=>array(

	    //'id',
        array(
            'header' => '#',
            'name' => 'id',
            'htmlOptions' => array(
                'style' => 'width:40px;white-space:nowrap'
            )
        ),

        array(
            'name' => 'created_at',
            'htmlOptions'=>array('style'=>'min-width: 160px;white-space:nowrap'),
        ),

		array(
		    'name' => 'subject_id',
		    'value' => '$data->subject->title',
            'filter' => CHtml::listData( FeedbackSubject::model()->findAll( array('order'=>'title') ), 'id', 'title'),
		),

        array(
            'name'=>'name',
            'value'=>'$data->name',
        ),

        array(
            'name'=>'email',
            'value'=>'$data->email',
        ),

        array(
            'class' => 'CLinkColumn',
            'header'=> $this->t('PROFILE'),
            'labelExpression' => '$data->user_id > 0 ? "' . $this->t('PROFILE') . '" : null',
            'urlExpression' => '$data->user_id > 0 ? array("/user/list/update", "id" => $data->user_id) : null',
        ),

        array(
            'name' => 'status_id',
            'value' => '$data->status ? $data->status->title : "новое"',
            'filter' => CHtml::listData(FeedbackStatus::model()->findAll(array('order'=>'title')),'id','title'),
            'htmlOptions'=>array('style'=>'width: 80px;'),
        ),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}&nbsp;&nbsp;{delete}',
            'buttons' => array(
                'view' => array(
                    'label'=> 'Смотреть данные',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    ),
                    'url' => function($data){
                        return Yii::app()->controller->itemUrl('view', $data->id);
                    }
                ),
                'delete' => array(
                    'label'=> 'Удалить',
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    ),
                )
            ),
            'htmlOptions'=>array('style'=>'white-space:nowrap'),
        ),

	),
)); ?>