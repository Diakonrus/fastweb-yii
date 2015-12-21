<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'basket-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),

)); ?>

<style>
    td {
        padding-left: 15px;
    }
</style>

	<?php echo $form->errorSummary($model); ?>

    <?php //echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150)); ?>

<table class="content_table" border="0">
    <thead>
    <tr>
        <th style="text-align: left;width:10px; padding-left: 15px;">
            <nobr>
                Параметр
            </nobr>
        </th>
        <th style="width:50px;">Значение</th>
    </tr>
    </thead>
    <tbody id="section_2" style="">
        <?php /* ?>
        <tr><td>Имя</td><td><a href="/admin/user/list/update?id=<?=$model->user_id;?>"><?=$model->user->last_name.' '.$model->user->first_name.' '.$model->user->middle_name;?></a></td></tr>
        <tr><td>Контактный телефон</td><td><?php echo $form->textField($model,'basket_phone',array('class'=>'span5','maxlength'=>150)); ?></td></tr>
        <tr><td>Адрес почты</td><td><a href="mailto:<?=$model->user->email;?>"><?=$model->user->email;?></a></td></tr>
        <tr><td>Примечание к заказу</td><td><?php echo $form->textArea($model,'basket_comments',array('class'=>'span5', 'rows'=>6, 'cols'=>50)); ?></td></tr>
        <tr><td>Адрес для доставки заказов</td><td><?php echo $form->textArea($model,'basket_address',array('class'=>'span5', 'rows'=>6, 'cols'=>50)); ?></td></tr>
        <tr><td>Ткущий статус</td><td><?php echo $form->DropDownList($model,'status', Basket::model()->getStatus(), array('class'=>'span5', 'rows'=>6, 'cols'=>50)); ?></td></tr>
        <?php */ ?>

        <?php
            $total = 0;
            foreach ($modelProduct as $data){
                $total = $total + (int)$data->quantity;
            }
        ?>

        <tr><td>Имя</td><td><a href="/admin/user/list/update?id=<?=$model->user_id;?>"><?=$model->user->last_name.' '.$model->user->first_name.' '.$model->user->middle_name;?></a></td></tr>
        <tr><td>Контактный телефон</td><td><?php echo $model->phone; ?></td></tr>
        <tr><td>Адрес почты</td><td><a href="mailto:<?=$model->user->email;?>"><?=$model->user->email;?></a></td></tr>
        <tr><td>Примечание к заказу</td><td><?php echo $model->comments;?></td></tr>
        <tr><td>Адрес для доставки заказов</td><td><?php echo $model->address;?></td></tr>
        <tr><td>Текущий статус</td><td><?=BasketOrder::model()->getDownliststatus($model->status);?></td></tr>
        <tr><td>Всего заказано товаров</td><td><?php echo $total;?></td></tr>
    </tbody>
</table>


<table class="content_table" border="0">
    <thead>
    <tr>
        <th style="text-align: left;width:10px; padding-left: 15px;">
            <b>Изменить данные о заказе</b>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php echo $form->DropDownListRow($model,'status', BasketOrder::model()->getStatus(), array('class'=>'span3')); ?>
            <?php echo $form->textAreaRow($model,'address',array('class'=>'span5', 'rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>150)); ?>
            <?php echo $form->textAreaRow($model,'comments',array('class'=>'span5', 'rows'=>6, 'cols'=>50)); ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="content_table" border="0">
    <thead>
    <tr>
        <th><b>Товар</b></th>
        <th><b>Количество</b></th>
        <th><b>Цна</b></th>
        <th><b>Сумма</b></th>
        <th style="width:100px;"><b>Действия</b></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($modelProduct as $data) { ?>
            <?php
            $productName = Yii::app()->db->createCommand()
                ->select('name')
                ->from('{{'.$data->module.'_elements}}')
                ->where('id='.(int)$data->item)
                ->queryRow();
            ?>
        <tr>
            <td><a href="/<?=$data->url;?>" target="_blank"><?=$productName['name'];?></a></td>
            <td><?php echo CHtml::textField('quantity_'.$data->id, $data->quantity, array('data-id'=>$data->id, 'class'=>'quantity_product')); ?></td>
            <td align="center"><?=$data->price;?></td>
            <td align="center"><?=$data->price*$data->quantity;?></td>
            <td align="center">
                <a class="delete" href="deleteproduct?id=<?=$data->id;?>" data-toggle="tooltip" onclick="return confirm('Вы действительно хотите удалить товар из заказа?'+'\n'+'Удаление всех товаров из заказа удалит сам заказ.') ? true : false;" title="" data-original-title="Удалить">
                    <i class="icon-trash"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<table class="content_table" border="0">
    <tbody>
    <tr>
        <td>
            <div class="form-actions">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'htmlOptions' => array('style' => 'margin-right: 20px', 'class'=>'applyBtn'),
                    'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
                )); ?>


                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'link',
                    'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
                    'url' =>$this->listUrl('orders'),
                )); ?>

            </div>
        </td>
    </tr>
    </tbody>
</table>


<?php $this->endWidget(); ?>

