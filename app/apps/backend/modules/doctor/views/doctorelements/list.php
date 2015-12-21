
<legend><?php echo Yii::t("Bootstrap", "LIST.DoctorElements" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = DoctorElements::model()->attributeLabels();


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'doctor-elements-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$model->search($param),
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
            'header'=> 'Картинка',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/doctor/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image )) {
                    $url_img = '/../uploads/filestorage/doctor/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image;
                }
                return '<img src="'.$url_img.'" style="width:80px" />';
            },
            'filter' =>'',
        ),


        array(
            'header'=> $labels["name"],
            'name'=> "name",
        ),
	
    		array(
            'name' => 'Специализация',
            'type'=>'raw',
            'value' => function($data){
                $spec = '';
                foreach ( DoctorSpecialization::model()->findAll('doctor_elements_id = '.$data->id) as $dataSpec ){
                    $spec .= '<a href="/admin/doctor/doctorrubrics/index?DoctorRubrics[id]='.$dataSpec->doctor_rubrics_id.'" target="_blank">'.(DoctorRubrics::model()->findByPk($dataSpec->doctor_rubrics_id)->name).'</a><BR>';
                }

                return $spec;
            },
            'filter' =>'',
        ),



        array(
            'header'=> 'Порядок',
            'name'=>'order_id',
            'value' =>  function($data){ return CHtml::textField('order_'.$data->id,$data->order_id, array("class"=>"order", "data-id"=>$data->id, "data-order"=>$data->order_id)); },
            'type'=>'raw',
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
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("doctorelements/update/id/" . $data->id)',
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

<table>
    <tr>
        <td><a href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create" class="btn">Добавить нового врача</a></td>
        <td><a class="btn btn-success" style="float:left; margin-left:15px;" href="javascript: saveForm();">Сохранить изменения</a></td>
    </tr>
</table>


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

    function selectall(){
        $('.selectProduct').prop('checked', true);
    }
    function unselectall(){
        $('.selectProduct').prop('checked', false);
    }

    //Сохраняет данные со страницы списка
    function saveForm(){
        var arrOrder = [];  //Порядок
        $('.order').each(function(){
            var val = $(this).data('id')+'|'+$(this).val();
            arrOrder.push( val );
        });

        $('#ajax_loader').show();
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:2,order:arrOrder},
            success: function(data) {
                $("#productlist-grid").load(document.location.href+" #productlist-grid");
                $('#ajax_loader').hide();
                alert('Данные сохранены');
            }
        });


    }

</script>

