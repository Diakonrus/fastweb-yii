
<legend>
    Скидки на товары.
    <?php
        if (!empty($model->element_id)){ ?>
            <BR>Товар: <a href="/admin/catalog/catalog/updateproduct?id=<?=(int)$model->element_id;?>" target="_blank"><?=CatalogElements::model()->findByPk((int)$model->element_id)->name;?></a>
    <?php } ?>
</legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = CatalogElementsDiscount::model()->attributeLabels();

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'catalog-elements-discount-grid',
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

        "id",
        array(
            'header'=> $labels["element_id"],
            'name'=> "element_id",
            'type'=>'raw',
            'value' =>  function($data) {
                return !empty($data->element) ? CHtml::link($data->element->name, '/admin/catalog/catalog/updateproduct?id=' . $data->element_id) : '-';
            },
            'filter' =>'',
        ),
        "count",
        "values",
        array(
            'header'=> $labels["type"],
            'name'=> "type",
            'value'=>'CatalogElementsDiscount::model()->getType($data->type)',
        ),
        array(
            'header'=> $labels["user_role_id"],
            'name'=> "user_role_id",
            'value'=>'$data->user_role_id==0?"Все":CatalogElementsDiscount::model()->getUserRole($data->user_role_id)',
        ),
        array(
            'header'=> 'Статус',
            'name'=> "status",
            'type'=>'raw',
            'value' =>  function($data){
                return '
                    <a href="#" class="on-off-product" data-id="'.$data->id.'" data-status="'.$data->status.'">
                        <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'.(($data->status==1)?'green':'red').'"></div>
                    </a>
                ';
            },
            'filter' =>'',
        ),


        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("catalogElementsDiscount/update/id/" . $data->id)',
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
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create<?=(!empty($model->element_id))?'?CatalogElementsDiscount[element_id]='.$model->element_id:'';?>"> Добавить скидку</a>
</div>

<script>
    //Меняем статус
    $(document).on('click', '.on-off-product', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:1, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });
</script>