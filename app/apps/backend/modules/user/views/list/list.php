<legend>Список пользователей</legend>

<?php

echo '<a href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/create" class="btn">Добавить</a>';

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

	'id'=>'user-grid',
	'enableHistory' => true,
	'dataProvider'=>$provider,
	'filter'=>$model,
	//'fixedHeader'=>true,
    'type' => 'bordered striped',

    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
	),

	'columns'=>array(

		array(
		    'header' => '#',
		    'name' => 'id',
		    'htmlOptions' => array(
		        'style' => 'min-width: 50px'
		    )
		),

		array(
		    'name' => 'username',
		    'htmlOptions' => array(
		        //'style' => 'width:100%'
		    )
		),

		'email',

		array(
		    'name' => 'role_id',
		    'value' => 'User::model()->getRole($data->role_id)',
            'filter' => User::model()->getRoles(),
		),

		array(
			'class' => 'bootstrap.widgets.TbDataColumn',
			'name'=>'created_at',
			'htmlOptions' => array( 'nowrap' => 'nowrap' ),
			'filter' => Yii::app()->controller->widget('bootstrap.widgets.TbDatePicker',array(
                'model'=>$model,
                'attribute'=>'created_at',
                'options'=>array(
                    'autoclose' => true,
                    'type' => 'Component',
                    'format'=>'yyyy-mm-dd',
                )
            ), true),
			//'type'=>'raw',
			//'value'=> 'substr($data["created"], 0, 16)',
		),

/*
		array(
		    'header' => 'Рассылка',
			'class' => 'bootstrap.widgets.TbDataColumn',
			'name'=>'subscribe',
			'type'=>'raw',
			'value'=> '($data["subscribe"]) ? \'<span class="icon-ok"></span>\' : \'\'',
            'filter' => array( 0 => 'Нет', 1 => 'Да' ),
            'filterHtmlOptions'=>array('style'=>'width: 58px'),
		),
*/

/*
		array(
		    'name' => 'score',
		    'header' => 'Баллов',
		),
*/

		array(
			'class' => 'bootstrap.widgets.TbDataColumn',
			'name'=>'state',
			'type'=>'raw',
			'value'=> function($data){
			    return User::model()->getState($data->state);
			},
            'filter' => User::model()->getStateList(),
            'filterHtmlOptions'=>array('style'=>'width: 58px'),
		),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
            'buttons' => array(
                'update' => array(
                    'label'=> 'Изменить',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    ),
                    'url' => function($data){
                        return Yii::app()->controller->itemUrl('update', $data->id);
                    }
                ),
                'delete' => array(
                    'label'=> 'Удалить',
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
));