<div class="block_content">
    <h1><?=$model->name;?></h1>
    <div class="catalog_photos catalog_tab">
        <div id="mainphoto">
            <?php
                //Проверяю существование файла
                $url_img = '/images/nophoto_100_100.jpg';
                $filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/small-'.$model->id.'.'.$model->image;
                if (file_exists($filename)){ $url_img = '/uploads/filestorage/catalog/elements/medium2-'.$model->id.'.'.$model->image; }
            ?>
            <a class="group" title="<?=$model->name;?>" href="<?=($url_img=='/images/nophoto_100_100.jpg')?($url_img):('/uploads/filestorage/catalog/elements/medium2-'.$model->id.'.'.$model->image);?>" rel="example_group">
                <img src="<?=$url_img;?>" title="<?=$model->name;?>" alt="<?=$model->name;?>" rel="example_group" width="192" style="border:1px solid #ddd;">
            </a>
            <div class="catalog_photos_2"> </div>
        </div>
    </div>
    <div class="characterisation">
        <table style="margin-bottom:15px;">
            <tbody>
            <tr>
                <td style="border:0px; padding-left:0px;">
                    <b>Название:</b>
                    <?=$model->name;?>
                    <br>
                    <b>Цена:</b>
                    <?=$model->price;?>
                </td>
                <td style="text-align:center; width:136px; border:0px;">
                    <div style="border:0px;">
                        <input id="basket_catalog_<?=$model->id;?>" class="basket_catalog_input" type="text" onkeypress="return testKey(event)" value="1" style="display:none;">
                        <script>
                            document.getElementById('basket_catalog_<?=$model->id;?>').style.display = 'none';
                        </script>

                        <a style="cursor: pointer" class="add_cart order" onclick="javascript:return SupposeInBasket('catalog/<?=$param;?>', 'catalog', 'price','<?=$model->id;?>','<?=$model->name;?>',0,document.getElementById('basket_catalog_<?=$model->id;?>').value,'','','','1')" href="javascript:void(0);" title="в корзину">
                            Купить
                        </a>
                    </div>
                    <div class="both"></div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="both"></div>
        <div class="both"></div>
    </div>
    <div class="clear"></div>
</div>

<!-- Вывод характеристик категории -->
<div class="model_chars">
    <?php if (!empty($modelChars)){ ?>

        <table class="description">
            <tbody>
            <tr>
                <th>Характеристика</th>
                <th>Значение</th>
            </tr>
            </tbody>
            <?php
            foreach ($modelChars as $data){
                echo '
                                    <tr>
                                        <td style="width:50%;">
                                        <span class="description-td"></span>
                                        '.$data['name'].'
                                        </td>
                                        <td style="width:50%;">'.$data['scale'].'</td>
                                    </tr>
                                    ';
            }
            ?>
        </table>
    <?php } ?>
</div>




