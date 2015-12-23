<section class="after-before mg-top-17 x">
    <div class="container befor-iner ">
        <div class="container video-caption">
            <h1>ДО и ПОСЛЕ</h1>
        </div>


        <?php $i = 1;?>
        <?php foreach ($model as $data) { ?>

            <?php if(( $i%1 )) { ?><div class="af-line"><?php } ?>

            <div class="after" data-toggle="modal" data-target="#myModal-g1">
                <a href="/beforeafter/<?=$data->url;?>"><?=$data->name;?></a>
                <span class="text-center block"><?=$data->description;?></span>
                <?php if ( $modelImage = BeforeAfterElements::model()->find('parent_id='.$data->id.' ORDER BY on_main DESC') ) { ?>
                    <?php
                    $url_before = '/uploads/filestorage/beforeafter/elements/medium-before_'.$modelImage->id.'.'.$modelImage->before_photo;
                    $url_after = '/uploads/filestorage/beforeafter/elements/medium-after_'.$modelImage->id.'.'.$modelImage->before_photo;
                    ?>
                    <figure>
                        <img src="<?=$url_before;?>">
                        <figcaption> ДО </figcaption>
                    </figure>
                    <figure>
                        <img src="<?=$url_after;?>">
                        <figcaption> ПОСЛЕ </figcaption>
                    </figure>
                <?php } ?>
            </div>

            <?php if(( $i%1 ) ) { ?></div><?php } ?>
            <?php ++$i; ?>
        <?php } ?>


    </div>

</section>

