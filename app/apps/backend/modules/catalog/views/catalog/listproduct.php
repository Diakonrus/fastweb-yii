<legend>Список элементов</legend>
<style>
    .content_table td {
        border-bottom: 1px solid #e6edec;
        border-left-style: hidden;
        border-right-style: hidden;
        padding: 6px;
        vertical-align: middle;
    }
</style>



<select name="CatalogElements[parent_id]" id="CatalogElements_parent" class="span5">

    <?php echo '<option value="0">/</option>'; ?>
    <? if (!empty($catalog)) : ?>
        <? foreach ($catalog as $category) : ?>
            <option value="<?=$category['id'] ?>"
                <?=isset($_GET['filterData']) &&  (int)$_GET['filterData']== $category['id']? 'selected="selected"' : ''?> >
                <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']), $category['name']?>
            </option>
        <? endforeach; ?>
    <? endif;?>

</select>


<?php

$assetsDir = Yii::app()->basePath;
$labels = CatalogElements::model()->attributeLabels();



$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'productlist-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'htmlOptions' => array('class' => 'content_table'),

    'dataProvider'=>$provider,
    'filter'=>$model,

	'columns'=>array(

        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows'=>2,
            'checkBoxHtmlOptions' => array(
                'class' => 'selectProduct',
            )
        ),

            /*
        array(
            'header'=> 'Картинка',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                $model = CatalogRubrics::model()->findByPk($dataProvider->parent_id);
                if ($model){
                    if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/rubrics/admin-'.$model->id.'.'.$model->image )) {
                        $url_img = '/../uploads/filestorage/catalog/rubrics/admin-'.$model->id.'.'.$model->image;
                    } else if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/h_rubrics/small-'.$model->id.'.'.$model->image )){
                        //картинка может быть от хендая
                        $url_img = '/../uploads/filestorage/catalog/h_rubrics/small-'.$model->id.'.'.$model->image;
                    }
                }
                return '<img src="'.$url_img.'" style="height:80px" />';
            },
            'filter' =>'',
        ),
        */

        array(
            'header'=> 'Картинка',
            'name'=> "image",
            'type'=>'raw',
            'value' => function($dataProvider){
                $url_img = '/images/nophoto_100_100.jpg';
                if (file_exists( YiiBase::getPathOfAlias('webroot').'/../uploads/filestorage/catalog/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image )) {
                    $url_img = '/../uploads/filestorage/catalog/elements/admin-'.$dataProvider->id.'.'.$dataProvider->image;
                }
                return '<img src="'.$url_img.'" style="width:80px" />';
            },
            'filter' =>'',
        ),


        array(
            'header'=> 'Наименование элемента',
            'name'=> "serch_name_code",
            'type'=>'raw',
            'value' => function($dataProvider){
                $result = '<a class="page_url" href="/'.(Pages::getBaseUrl(4)).(CatalogElements::model()->getProductUrl($dataProvider)).'" style="margin-left: 20px;" target="_preview">'.$dataProvider->name.'</a></BR>';
                return $result;
            },
            'filter' => CHtml::textField('CatalogElements[serch_name_code]', '', array('style'=>'width:100%', 'placeholder'=>'Введите название')),
        ),


        array(
            'header'=> 'Цена',
            'name'=> "price",
            'type'=>'raw',
            'value' =>  function($data){ return CHtml::textField('price_'.$data->id,$data->price, array("class"=>"price", "data-id"=>$data->id, "data-price"=>$data->price)); },
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
            'template' => '{update_product}  {edit_chars}  {discount}  {delete_product}',

            'buttons' => array(
                'update_product' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-pencil',
                        'title'=>'Редактировать',
                    ),
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/updateproduct", array("id"=>$data->id))',
                ),
                'edit_chars' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-cog',
                        'title'=>'Редактировать свойства',
                    ),
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/listchars", array("id"=>$data->id, "type_parent"=>2))',
                ),
                'discount' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-gift',
                        'title'=>'Скидки на товар',
                    ),
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/catalogelementsdiscount/index", array("CatalogElementsDiscount[element_id]"=>$data->id))',
                ),
                'delete_product' => array(
                    'label'=>'',
                    'options'=>array(
                        'data-toggle' => 'tooltip',
                        'class'=>'icon-trash',
                        'title'=>'Удалить',
                    ),
                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/deleteproduct", array("id"=>$data->id))',
                ),
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
));

?>

<div id="ajax_loader" style="display: none;"><img width="40px;" style="position:absolute; margin-top:10px; margin-left:-40px;" src="/images/admin/ajaxloader.gif"></div>
<div class="buttons">
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/createproduct"> Добавить товар</a>
    <a class="btn btn-danger" style="float:left; margin-left:15px; margin-top:14px" href="javascript: deleteselected();">Удалить отмеченные</a>
    <a class="btn btn-success" style="float:left; margin-left:15px; margin-top:14px" href="javascript: saveForm();">Сохранить изменения</a>
</div>


<script>
    //Меняем статус
    $(document).on('click', '.on-off-product', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:3, id:$(this).data('id')}
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

    //Удаляем отмеченые
    function deleteselected(){
        var arr = [];
        $('table tbody td.checkbox-column input:checkbox:checked').each(function() {
            arr.push($(this).val());
        });

        if ( arr.length > 0 ) {
            $('#ajax_loader').show();
            $.ajax({
                type: 'POST',
                url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
                dataType: "json",
                data: {type:4, id:arr},
                success: function(data) {
                    $("#productlist-grid").yiiGridView('update');
                    $('#ajax_loader').hide();
                    alert('Записи удалены');
                }
            });
        }
    }


    //Сохраняет данные со страницы списка
    function saveForm(){
        var arrPrice = [];  //Цены
        $('.price').each(function(){
            var val = $(this).data('id')+'|'+$(this).val();
            arrPrice.push( val );
        });
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
            data: {type:5, price:arrPrice, order:arrOrder},
            success: function(data) {
                $("#productlist-grid").load(document.location.href+" #productlist-grid");
                $('#ajax_loader').hide();
                alert('Данные сохранены');
            }
        });


    }

    //фильтр
    $(document).on('change', '#CatalogElements_parent', function(){
        location.href = '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/listelement?filterData='+$(this).val();
    });


</script>