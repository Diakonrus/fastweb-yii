<legend>Список ролей</legend>

<?php

echo '<a style="margin-bottom:10px;" href="/admin/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/createrole" class="btn">Добавить</a>';

echo '
<div>
    <p><b>Внимание, при удалении роли, все пользователи имеющие эту, удаляемую, роль так же будут удалены!</b></p>
</div>
';
$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

	'id'=>'user-grid',
	'enableHistory' => true,
	'dataProvider'=>$provider,
	'filter'=>$model,
	//'fixedHeader'=>true,
    'type' => 'bordered striped',
/*
    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
	),
*/
	'columns'=>array(

        'description',
        'name',


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
                        return Yii::app()->controller->itemUrl('updaterole', $data->id);
                    },
                    'visible'=>'$data->name!="admin"?true:false'
                ),
                'delete' => array(
                    'label'=> 'Удалить',
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    ),
                    'url' => function($data){
                        return Yii::app()->controller->itemUrl('deleterole', $data->id);
                    },
                    'visible'=>'$data->name!="admin"?true:false'
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),

	),
));