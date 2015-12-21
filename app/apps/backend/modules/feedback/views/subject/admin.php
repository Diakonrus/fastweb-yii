<legend><?php echo $this->t('SUBJECT_MANAGE') ?></legend>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

	'id'=>'feedback-subject-grid',
	'enableHistory' => true,

	'dataProvider'=>$model->search(),
	'filter'=>$model,
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
                'style' => 'width:50px;white-space:nowrap'
            )
        ),

		'title',

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
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
                    ),
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),

            /* всё равно обновим, поскольку некоторые записи могут быть удалены
            'afterDelete'=>'function(link,success,data){
                if(!success) {
                    jQuery("#feedback-subject-grid").yiiGridView("update");
                }
            }',*/
        ),

	),
)); ?>