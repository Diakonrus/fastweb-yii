<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle($model->id)?></h1>

<div>
    <?=$model->content;?>
</div>
<div class="clearfix"></div>

<?=$modelTabs;?>



<?php if (!empty($modelCatalog)) { ?>
    <div class="tovar_container tovar_container2">
        <div class="block_name">Популярные товары</div>
        <?php foreach ($modelCatalog as $data) { ?>

            <div class="items-block-item">
                <a href="/katalog-shub/<?=$data->id;?>" class="items-block-item-img">
                    <table>
                        <tr><td></td></tr>
                        <tr><td class="rollover">
                                <?php if ($data->shares==1){ ?>
                                    <div class="shares">

                                    </div>
                                <?php } ?>
                                <img src="/uploads/filestorage/catalog/elements/medium-<?=$data->id;?>.<?=$data->image;?>" />
                            </td></tr>
                        <tr><td></td></tr>
                    </table>
                </a>
                <div class="product_info_block">
                    <a class="items-block-item-name" href="/katalog-shub/<?=$data->id;?>" ><?=$data->name;?></a>
                    <div class="item-price-count">
                        <div class="items-block-item-price <?php if ($data->price_old > 0){ ?> old_price_active <?php } ?>"><?=$data->price;?> руб.</div>
                        <?php if ($data->price_old > 0){ ?>
                            <div class="old_price_product_cat">
                                <?=$data->price_old;?> руб.
                            </div>
                        <?php } ?>


                        <div class="item-count-area">
                            <a href="" class="item-count-inc"></a>
                            <input value="1" class="item-count" type="text">
                            <a href="" class="item-count-dec"></a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="order_one_click">
                        <a href="javascript:void(0)"
                           class="fastorder"
                           idx="<?=$data->id;?>"
                           names="<?=$data->name;?>"
                           pic="/uploads/filestorage/catalog/elements/medium-<?=$data->id;?>.<?=$data->image;?>"
                           price="<?=$data->price?>"
                           old_price="<?=$data->price_old;?>"
                           sales="<?php if ($data->shares==1){ ?>1<?php } ?>"
                            >
                            Заказать
                        </a>
                    </div>
                </div>



            </div>



        <?php } ?>
    </div>
<?php } ?>


<?php if (!empty($modelNews)) { ?>

    <div class="home_news_block">
        <div class="block_name">Новости</div>
        <section class="items">
            <?php foreach ($modelNews as $data) { ?>

                <article class="item">
                    <div class="date_news"><?=date('d.m.Y', strtotime($data->maindate));?></div>
                    <a href="/news/<?=$data->id;?>" class="news_a"><?=$data->name;?></a>
                    <div class="itntrotext_news">
                        <?=$data->brieftext;?>
                    </div>
                </article>

            <?php } ?>
        </section>
    </div>


<?php } ?>

