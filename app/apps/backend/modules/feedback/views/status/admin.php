<legend><?php echo $this->t('STATUS_MANAGE') ?></legend>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

	'id'=>'feedback-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'type' => 'bordered striped',

	'enableHistory' => true,

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
                'style' => 'width:50px;white-space:nowrap'
            )
        ),

		'title',

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'label'=> 'Изменить',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
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