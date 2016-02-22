<?php
if (!empty($modelElements)){
    ?>

    <article>
        <div class="article_block">
                <?=$modelElements->name;?>
                <span>/ <?=(date('d.m.Y', strtotime($modelElements->maindate)));?></span>
            <div class="article_block_content">
                <?php
                if (!empty($modelElements->image)){ ?>
                    <div style="float:left;">
                        <img src="/uploads/filestorage/article/elements/small-<?=$modelElements->id;?>.<?=$modelElements->image;?>">
                    </div>
                <?php }
                ?>
                <div style="padding-left: 120px;">
                    <?=$modelElements->description;?>
                </div>
            </div>
        </div>
    </article>

<?php } ?>
