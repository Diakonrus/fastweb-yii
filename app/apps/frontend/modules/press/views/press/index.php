<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1>ПРЕССА О НАС</h1>
            <ul class="tab-lincks">
            <?php foreach ($model['group'] as $data) { ?>
                <li>
                    <a class="<?=($param==$data->id?'active':'');?>" href="/press/press-<?=$data->url;?>"><?=$data->name;?></a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </main>
</section>


<section class="news-block">
    <div class="container news-all pressa">
        <main class="all gray-f" role="main">
            <?php $i = 0; ?>
            <?php foreach ( $model['first_group'] as $data ) { ?>
                <?php ++$i;?>
                <?php if ($i%2!=0){ echo '<div class="press-line">'; }?>

                <div class="press">
                    <figure>
                        <img src="/uploads/filestorage/press/elements/<?=$data->id;?>.<?=$data->image;?>" alt="">
                    </figure>

                    <article>
                        <span><?=Press::model()->getDate($data->maindate);?></span>
                        <a href="/press/<?=$data->id;?>"><?=$data->name;?></a>
                        <?=$data->brieftext;?>
                    </article>
                </div>

                <?php if ($i%2==0){ echo '</div>'; }?>
            <?php } ?>
        </main>
    </div>
</section>

