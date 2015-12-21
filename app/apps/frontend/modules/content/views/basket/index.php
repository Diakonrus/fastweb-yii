<style>
    .new_row {
        clear: both;
    }
    .alert-error {
        color: red;
    }
    td {
        padding: 10px;
    }
</style>

<div class="block_content">
    <p class="tema3">Оформление заказа</p>


    <div id="basket_form_block">

    <form id="basket_form" method="post">
    <table id="basketLists" class="info2" cellspacing="0" cellpadding="0">

        <tbody>
            <tr class="glav">
                <td>Наименование</td>
                <td>Каталожный номер</td>
                <td>Комплект</td>
                <td>Количество</td>
                <td>Цена</td>
                <td> </td>
            </tr>

            <?php foreach ($model as $key=>$value){ ?>

                <tr>
                    <td><?=$value['name'];?></td>
                    <td><?=$value['code'];?></td>
                    <td><?=$value['qty'];?></td>
                    <td class="width_50"><input class="inputtext input_quantity" data-id="<?=$value['key'];?>" type="text" style="width: 100px;" value="<?=$value['quantity'];?>" name="<?=$value['key'];?>"></td>
                    <td>
                        <?=$value['price']; ?>
                    </td>
                    <td><a data-id="<?=$value['key'];?>" href="#" class="delete_btn">Удалить</a></td>
                </tr>

            <?php } ?>


        </tbody>

    </table>


    <table class="cabinet_shopcart_keytable" border="0">
        <tbody>
        <tr align="right">
            <td>
                <?php if (!empty($model)){ ?>
                    <input class="send basket-next-url" type="submit" value="Продолжить" name="issue">
                    <input class="send recount-url" type="submit" value="Пересчитать" name="recount">
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

    <div id="basket_address_block" style="display: none;">


        <?php echo $form->errorSummary($modelBasketOrder); ?>

        <div class="new_row">
            Адрес доставки заказа: *<BR>
            <?php echo $form->textArea($modelBasketOrder,'address',array('class'=>'textarea2')); ?>
        </div>

        <div class="new_row">
            Телефон: <BR>
            <?php echo $form->textField($modelBasketOrder,'phone',array('class'=>'inputtext','maxlength'=>254)); ?>
        </div>

        <div class="new_row">
            Примечания: <BR>
            <?php echo $form->textArea($modelBasketOrder,'comments',array('class'=>'textarea2')); ?>
        </div>

        <table class="cabinet_shopcart_keytable" border="0">
            <tbody>
            <tr align="right">
                <td>
                    <?php if (!empty($model)){ ?>
                        <input class="send basket-back-url" type="submit" value="Назад" name="issue">
                        <input class="send applyForm" type="submit" value="Оформить" name="complite">
                    <?php } ?>
                </td>
            </tr>
            </tbody>
        </table>


    </div>

    <?php $this->endWidget(); ?>





</div>

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
                $("#basketLists").load(document.location.href + " #basketLists");
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