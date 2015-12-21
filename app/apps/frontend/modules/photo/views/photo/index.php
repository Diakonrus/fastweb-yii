<main class="all" role="main">
    <div class="container video-caption">
        <ul class="tab-lincks">
            <?php foreach ($menu_top as $id=>$data) { ?>

                <li>
                    <a class="<?=($param->id==$id?'active':'');?>" href="/photo/<?=$data['url']?>"><?=$data['name'];?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</main>



<!-- Карусель -->
<?php if(!empty($model['elements'])){ ?>
    <section class="video-block" style="display: none;">

        <main role="main" class="all">

            <div class="container">
                <div id="myCarousel1" class="carousel slide" data-interval="false">
                    <!-- Indicators -->
                    <ol class="carousel-indicators hidden">
                        <?php foreach ($model['elements'] as $data) { ?>
                            <li class="ol_myCarousel" id="ol_myCarousel<?= $data->id; ?>"
                                data-target="#myCarousel<?= $data->id; ?>" data-slide-to="0"></li>
                        <?php } ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner video-slider">
                        <?php foreach ($model['elements'] as $data) { ?>
                            <div class="carousel_itm item" id="carousel_itm_<?= $data->id; ?>">
                                <img src="/uploads/filestorage/photo/elements/<?= $data->id; ?>.<?= $data->image; ?>"
                                     alt="">
                            </div>
                        <?php }  ?>
                    </div>
                    <!-- Controls -->
                    <a class="left" href="#myCarousel1" data-slide="prev"></a>
                    <a class="right" href="#myCarousel1" data-slide="next"></a>
                </div>
            </div>

    </section>
<?php } ?>



<div class="news-block">
    <main class="all" role="main">
        <div class="container news-all photo">

            <?php if(!empty($model['catalogs'])){ ?>

                <?php
                    foreach ($model['catalogs'] as $data){
                        $images_id = $data->id;
                        $images_name = $data->name;
                        $images_url = $data->url;
                        $images_image = '/images/nophoto.jpg';
                        if (!empty($data->image)){
                            //Есть картинка раздела - ставим ее
                            $images_image = "/uploads/filestorage/photo/rubrics/medium-" . $data->id . "." . $data->image;
                        } else {
                            //Картинки раздела нет - тянем первую из фотографий раздела (если они там есть)
                            if ( $img_model = PhotoElements::model()->find('parent_id = '.$data->id.' AND `status`=1') ){
                                $images_id = $img_model->id;
                                $images_image = "/uploads/filestorage/photo/elements/medium-" . $img_model->id . "." . $img_model->image;
                            }
                        }
                ?>

                        <figure class="title-show" title="<?=$images_name;?>">
                            <a href="/photo/<?=$images_url;?>">
                                <img src="<?=$images_image;?>">
                            </a>
                        </figure>

                <?php } ?>


            <?php } ?>

            <?php if(!empty($model['elements'])){ ?>

                <?php
                foreach ($model['elements'] as $data){
                    $images_id = $data->id;
                    $images_name = $data->name;
                    $images_url = $data->url;
                    $images_image = '/images/nophoto.jpg';
                    if (!empty($data->image)){
                        //Есть картинка раздела - ставим ее
                        $images_image = "/uploads/filestorage/photo/elements/medium-" . $data->id . "." . $data->image;
                    }
                    ?>

                    <figure class="title-show" title="<?=$images_name;?>">
                        <a href="#" onclick="$('.ol_myCarousel').removeClass('active'); $('.carousel_itm').removeClass('active'); $('#ol_myCarousel<?=$images_id;?>').addClass('active');  $('#carousel_itm_<?=$images_id;?>').addClass('active'); $('.video-block').show(); return false;">
                            <img src="<?=$images_image;?>">
                        </a>
                    </figure>

                <?php } ?>


            <?php } ?>


        </div>
    </main>
</div>


<script>
    $('.title-show').hover(
        function () {
            var cap= $(this).attr('title');
            var apTeg = '<figcaption id="caption">'+cap+'</figcaption>';
            $(this).append(apTeg);
            $(this).children('#caption').animate({bottom: 0}, 500);

        },
        function () {
            var deleted = $(this).children('#caption');
            $(this).children('#caption').animate({bottom: -40}, 500);
            setTimeout(function() {
                deleted.remove();
            }, 700);

        }
    );
</script>

