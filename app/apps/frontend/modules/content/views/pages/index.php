<?php if ($model->main_page == 0) {?>
<section>
    <main role="main" class="all gray-f">
        <div class="container news-all">
            <?=$model->content;?>
        </div>
    </main>
</section>
<?php } else { ?>
    <?=$model->content;?>
<?php } ?>

<?=$modelTabs;?>