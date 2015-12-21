<p class="tema3">История покупок</p>
<table class="info2" cellspacing="0" cellpadding="0">
    <tbody>

        <tr class="glav">
            <td>Номер заказа</td>
            <td>Ссылка но товар</td>
            <td>Количество</td>
            <td>Дата</td>
            <td>Адрес доставки</td>
            <td>Статус</td>
        </tr>

        <?php

            foreach ($model as $data){
                $url = '';
                $quantity = 0;
                foreach (BasketOrder::model()->getProductInOrder($data->id) as $value){
                    $url.= '<a href="'.$value["url"].'">'.$value["url"].'</a></BR>';
                    $quantity = $quantity + (int)$value['quantity'];
                }
                echo '
                    <tr>
                        <td>Заказ № '.$data->id.'</td>
                        <td>'.$url.'</td>
                        <td>'.$quantity.'</td>
                        <td>'.(date('d.m.Y', strtotime($data->created_at))).'</td>
                        <td>'.$data->address.'</td>
                        <td>'.BasketOrder::model()->getDownliststatus($data->status).'</td>
                    </tr>
                ';
            }
        ?>
    </tbody>
</table>
