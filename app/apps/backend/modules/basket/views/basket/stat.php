<style>
    .prokrutka {
        width:550px;
        height:300px;
        background: #fff;
        border: 1px solid #C1C1C1;
        overflow: auto;
    }
</style>
<?php
    $total = 0;
    foreach ($model as $key=>$val){
        foreach ($val as $value){
            $total = $total + $value['quantity'];
        }
    }
?>
<form action="?" method="post">
<table class="content_table edit_table" width="100%" border="0">
    <thead>
    <tr>
        <th style="text-align:left;" colspan="2"> Фильтр заказов </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php
                    foreach (BasketOrder::model()->getStatus() as $key=>$val){
                        echo '<input type="checkbox" value="'.$key.'" name="Filter[status]['.$key.']">'.$val.'<BR>';
                    }
                ?>
                <?php
                    echo $this->widget('bootstrap.widgets.TbDateRangePicker', array(
                        'name'=>'Filter[period]',
                        'options' => array(
                            'language' => 'ru'
                        ),
                        'callback' => 'js:function(){$(this.element).change();}'
                    ),true);

                ?>
            </td>
        </tr>
    </tbody>
</table>
    <input type="submit" value="Фильтровать" name="statselect">
</form>

<p>Всего заказано <?=(count($model));?> позиций. Общее количество заказаных товаров: <?=$total;?> </p>
<b>Список заказаных товаров</b><BR>
<div class="prokrutka">
<?php
    foreach ($model as $key=>$val){
        foreach ($val as $value){
            echo '<a href="/admin/basket/basket/update?id='.$key.'">[Заказ № '.$key.'] '.$value['name'].': '.$value['quantity'].' шт. от '.$value['date'].'</a><BR>';
        }
    }
?>
</div>

