<div class="block_content">
    <style>
        table.spo th, table.spo td {
            border: 1px solid #dddddd;
            padding: 5px 11px;
        }
    </style>

    <div class="tumbs">
        <h1> <?=$modelRubric->name;?> </h1>
        <div class="description_catalog">
            <div class="clear"></div>
            <table class="spo tbl" cellspacing="0" cellpadding="0">
                <tbody>
                <tr class="glav" style="background: none repeat scroll 0 0 #eee;">
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Действие</th>
                </tr>
                <?php $i = 0; ?>
                <?php foreach ($model as $data){ ?>
                    <?php ++$i; ?>
                    <tr <?=(( $i & 1)?(''):('style="background: none repeat scroll 0 0 #eee;"'));?>>
                        <td>
                            <a title="" href="/catalog/<?=$param;?>/<?=$data->id;?>/">
                                <?php
                                    //Проверяю существование файла
                                    $url_img = '/images/nophoto_100_100.jpg';
                                    $filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/small-'.$data->id.'.'.$data->image;
                                    if (file_exists($filename)){ $url_img = '/uploads/filestorage/catalog/elements/medium2-'.$data->id.'.'.$data->image; }
                                ?>
                                <img src="<?=$url_img;?>" title="<?=$data->name;?>" alt="<?=$data->name;?>" width="150px" style="border:1px solid #ddd;">
                            </a>
                        </td>
                        <td>
                            <div class="element_name">
                                <strong>
                                    <a title="<?=$data->name;?>" href="/catalog/<?=$param;?>/<?=$data->id;?>/">
                                    <?=$data->name;?>
                                    </a>
                                </strong>
                            </div>
                        </td>
                        <td><nobr><?=$data->price;?></nobr></td>
                        <td style="text-align:center;">
                            <input id="basket_catalog_<?=$data->id;?>" class="basket_catalog_input" type="text" value="1" onkeypress="return testKey(event)">
                            <script>
                                document.getElementById('basket_catalog_<?=$data->id;?>').style.display = 'none';
                            </script>
                            <a title="в корзину" href="javascript:void(0);" onclick="javascript:return SupposeInBasket('catalog/<?=$param;?>/<?=$data->id;?>', 'catalog', 'price','<?=$data->id;?>','<?=$data->name;?>',0,document.getElementById('basket_catalog_<?=$data->id;?>').value,'','','','1')">
                                <img width="16" height="16" src="/images/order.png">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>



<script>
    $("a[href^='<?=$_SERVER['REQUEST_URI'];?>']").css({fontWeight: "bold"});
    $("a[href^='<?=$_SERVER['REQUEST_URI'];?>']").parent().parent().show();
</script>