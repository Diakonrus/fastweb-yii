
<legend><?php echo Yii::t("Bootstrap", "LIST.UserGroupRule" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = UserGroupRule::model()->attributeLabels();


/*
$this->widget('backendfilterWidget', array(
    'listId' => 'user-group-rule-grid',
    'model' => $model,
    'columns'=>array(


            
            array(
            'user_role_id',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'module_id',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'access_type',
            'htmlOptions'=>array('class'=>'span5')
        ),
        
            array(
            'created_at',
            'date',
            'range'=>true
        ),
        
    ),
));
*/

echo '<a href="usergrouprule/create" class="btn">Добавить</a>';

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'user-group-rule-grid',
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
            'header'=> $labels["user_role_id"],
            'name'=> "user_role_id",
            'value' => 'UserGroupRule::model()->getDownrolelist($data->user_role_id)',
            'filter' => UserGroupRule::model()->getRoleList(),
        ),
        
	
            array(
            'header'=> $labels["module_id"],
            'name'=> "module_id",
            'value' => 'UserGroupRule::model()->getDownmodulelist($data->module_id)',
            'filter' => UserGroupRule::model()->getModulesList(),
        ),
        
	
            array(
            'header'=> $labels["access_type"],
            'name'=> "access_type",
            'value' => 'UserGroupRule::model()->getDownaccesslist($data->access_type)',
            'filter' => UserGroupRule::model()->getAccessType(),
        ),
        
	/*
            array(
            'header'=> $labels["created_at"],
            'name'=> "created_at",
        ),
    */

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("usergrouprule/update/id/" . $data->id)',
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
