
<legend><?php echo Yii::t("Bootstrap", "LIST.FaqAuthor" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = FaqAuthor::model()->attributeLabels();


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'faq-author-grid',

    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'htmlOptions' => array('class' => 'content_table'),

    'dataProvider'=>$provider,
    'filter'=>$model,


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
            'header'=> $labels["email"],
            'name'=> "email",
        ),
        


        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{link}',
            'buttons' => array(
                'link' => array(
                    'label'=> 'Вопросы пользователя',
                    'options'=>array(
                        //'class' => 'btn btn-small update',
                        'target' => '_blank',
                    ),
                    'url'=>'Yii::app()->createUrl("/faq/faq/index", array("FaqElements[author_id]"=>$data->id))',
                ),
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),



        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("faqauthor/update/id/" . $data->id)',
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

<div class="buttons">
    <a class="btn btn-primary" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" style="margin-top:14px; float:left; margin-left:15px"> Добавить нового автора вопроса</a>
</div>
