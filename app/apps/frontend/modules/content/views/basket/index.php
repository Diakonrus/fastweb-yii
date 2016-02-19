<?
$this->pageTitle = 'Оформление заказа - '.$_SERVER['HTTP_HOST'];
?>
<h1 class="lined nopaddingtop" style="margin-top: 10px;">Оформление заказа</h1>







    <div id="basket_form_block">

    <form id="basket_form" method="post">
    <table id="basketLists" class="info2 table  table-striped  table-bordered table-hover" cellspacing="0" cellpadding="0">

        <tbody >
            <tr class="glav">
                <th>Наименование</th>
                <th>Модель</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th> </th>
            </tr>

            <?php
            $summ=0;
             foreach ($model as $key=>$value){ 
             ?>
                <tr>
                    <td><a href="/<?=$value['key']?>" target="_blank"><?=$value['name'];?></a></td>
                    <td><?=$value['code'];?></td>
                    <td class="width_50">
                   
                    
  <div class="form-group basket_count">
    <div class="input-group">
      <div class="input-group-addon basket_count_minus" >
	      <i class="glyphicon glyphicon-minus"></i>
      </div>
      <input type="text" class="form-control inputtext input_quantity" 
             data-id="<?=$value['key'];?>" 
             name="<?=$value['key'];?>" 
             value="<?=$value['quantity'];?>">
      <div class="input-group-addon basket_count_plus">
      	<i class="glyphicon glyphicon-plus"></i>
      </div>
    </div>
  </div>
				
                    </td>
                    <td>
                        <?=$value['price']; ?>  руб.
                    </td>
                    <td>
                        <?=$value['price']*$value['quantity']; ?>  руб.
                    </td>
                    <td><a data-id="<?=$value['key'];?>" href="#" class="delete_btn">Удалить</a></td>
                </tr>
						
            <?php 
            $summ+=($value['price']*$value['quantity']);
            } ?>
            
                <tr class="success">
                    <td colspan="4">Итого</td>
                    <td><?=$summ?> руб.</td>
                    <td></td>
                </tr>


        </tbody>

    </table>


    <table class="cabinet_shopcart_keytable" border="0">
        <tbody>
        <tr align="right">
            <td>
                <?php if (!empty($model)){ ?>
                    <input class="send basket-next-url btn btn-primary" type="submit" value="Оформить заказ" name="issue">
                    <input class="send recount-url btn btn-info" type="submit" style="display:none;" value="Пересчитать" name="recount">
                <?php } ?>
            </td>
        </tr>
        </tbody>
    </table>
    </form>

    </div>



    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'basketaddres-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
        'type' => 'horizontal',

    )); ?>

    <?php
        if ($form->errorSummary($modelBasketOrder)){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".basket-next-url").click();
                    });
                </script>
            ';
        }
    ?>

<div id="basket_address_block" class="col-md-12" style="display: none;">

	<?php echo $form->errorSummary($modelBasketOrder); ?>


	<div class="form-group">
		<label> Адрес доставки заказа: *</label>
		<?php echo $form->textArea($modelBasketOrder,'address',array('class'=>'form-control')); ?>
	</div>



	<div class="form-group">
		<label>Телефон:</label>
		<?php echo $form->textField($modelBasketOrder,'phone',array('class'=>'form-control','maxlength'=>254)); ?>
	</div>

	<div class="form-group">
		<label>Примечания:</label>
		<?php echo $form->textArea($modelBasketOrder,'comments',array('class'=>'form-control')); ?>
	</div>




<table class="cabinet_shopcart_keytable" border="0" style="margin-left:-15px;">
    <tbody>
    <tr>
        <td>
            <?php if (!empty($model)){ ?>
                <input class="send basket-back-url  btn btn-default" type="submit" value="Назад" name="issue">
                <input class="send applyForm  btn btn-primary" type="submit" value="Оформить" name="complite">
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>


    </div>

    <?php $this->endWidget(); ?>






<script>

    //Пересчет
    $(document).on('click', '.recount-url', function(){
        $.ajax({
            url: '/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxrecount',
            type: "POST",
            dataType: "html",
            data: $("#basket_form").serialize(),
            success: function (response) {
            		
                get_basket_count();
                $("#basketLists").load(document.location.href + " #basketLists tbody");
            }
        });
        return false;
    });

    //Удалить
    $(document).on('click', '.delete_btn', function(){
        $.ajax({
            url: '/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxdelete',
            type: "POST",
            dataType: "html",
            data: {id:$(this).data('id')},
            success: function (response) {
                get_basket_count();
                $("#basket_form_block").load(document.location.href + " #basket_form_block");
            }
        });
        //get_basket_count();
        //$(this).parent().parent().remove();
        return false;
    });

    //дальее
    $(document).on('click', '.basket-next-url', function(){
        $('#basket_form_block').hide();
        $('#basket_address_block').show();
        return false;
    });

    //назад
    $(document).on('click', '.basket-back-url', function(){
        $('#basket_form_block').show();
        $('#basket_address_block').hide();
        return false;
    });

    //Оформить заказ
    $(document).on('click', '.applyForm', function(){
        if ( $('#BasketOrder_address').val().length == 0 ){
            alert('Вы не указали аддрес доставки!')
            return false;
        }
    });


</script>
