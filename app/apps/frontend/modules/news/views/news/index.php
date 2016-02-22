<div class="container">

    <?php foreach ($model as $data) { ?>
        <b><a href="<?=Pages::returnUrl($data->url);?>">
                <?=$data->name;?> (
                <?=NewsElements::model()->getCountElements($data->id);?>)</a></b>
    <?php } ?>

</div>


<?php
if (!empty($modelElements)){
    ?>
    <?php foreach ($modelElements as $data) { ?>

        <news>
            <div class="news_block">
                <a href="<?=Pages::returnUrl($data->id);?>">
                    <?=$data->name;?>
                    <span>/ <?=(date('d.m.Y', strtotime($data->maindate)));?></span>
                </a>
                <div class="news_block_content">
                    <?php
                    if (!empty($data->image)){ ?>
                        <div style="float:left;">
                            <img src="/uploads/filestorage/news/elements/small-<?=$data->id;?>.<?=$data->image;?>">
                        </div>
                    <?php }
                    ?>
                    <div style="padding-left: 120px;">
                        <?=$data->brieftext;?>
                    </div>
                </div>
            </div>
        </news>


    <?php } ?>
<?php } ?>
