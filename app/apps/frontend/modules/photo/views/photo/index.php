<main class="all" role="main">
    <div class="container">
        <ul class="tab-lincks">
            <?php
            if ($is_root){ $id_selectrd = $modelRoot->id; } else {$id_selectrd = $modelRoot->parent_id;  }
            ?>
            <?php foreach ($root->descendants(1,1)->findAll() as $data) { ?>
                <li>
                    <a class="<?=($id_selectrd==$data->id?'active':'');?>" href="/photo/<?=$data['url']?>"><?=$data['name'];?></a>

                </li>
            <?php } ?>
        </ul>
    </div>
</main>



<!-- Карусель -->
<?php if(!$is_root){ ?>
    <section class="video-block" style="display: none;">

        <main role="main" class="all">

            <div class="container">
                <div id="myCarousel1" class="carousel slide" data-interval="false">
                    <!-- Indicators -->
                    <ol class="carousel-indicators hidden">
                        <?php foreach ($model as $data) { ?>
                            <li class="ol_myCarousel" id="ol_myCarousel<?= $data->id; ?>"
                                data-target="#myCarousel<?= $data->id; ?>" data-slide-to="0"></li>
                        <?php } ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner video-slider">
                        <?php foreach ($model as $data) { ?>
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

<style>
    .setRedColor {
        border:2px solid red;
        padding:2px;
    }
</style>
<div class="news-block">
    <main class="all" role="main">
        <div class="container news-all photo">

            <?php if(!empty($model)){ ?>

                <?php
                    $i = 0;
                    foreach ($model as $data){
                        ++$i;
                        $images_id = $data->id;
                        $images_name = $data->name;
                        $images_url = $data->url;
                        $images_image = '/images/nophoto.jpg';
                        if (!empty($data->image)){
                            //Есть картинка раздела - ставим ее
                            if ($is_root){ $images_image = "/uploads/filestorage/photo/rubrics/medium-" . $data->id . "." . $data->image; }
                            else { $images_image = "/uploads/filestorage/photo/elements/medium-" . $data->id . "." . $data->image; }
                        }
                ?>
                        <figure class="title-show" title="<?=$images_name;?>">
                            <?php
                                if ($is_root){ ?>
                                    <a href="/photo/<?=$images_url;?>">
                                        <img src="<?=$images_image;?>">
                                    </a>
                            <?php
                                    } else {
                            ?>
                                    <a href="#" data-num="<?=$i;?>" onclick="num_count = $(this).data('num'); $('figure').removeClass('setRedColor');$(this).parent().addClass('setRedColor'); $('.ol_myCarousel').removeClass('active'); $('.carousel_itm').removeClass('active'); $('#ol_myCarousel<?=$images_id;?>').addClass('active');  $('#carousel_itm_<?=$images_id;?>').addClass('active'); $('.video-block').show(); return false;">
                                        <img src="<?=$images_image;?>">
                                    </a>
                            <?php } ?>


                        </figure>

                <?php } ?>


            <?php } ?>


        </div>
    </main>
</div>


<script>
    var total_count = $("figure").length;
    var num_count = 1;

    $(document).on('click','.right, .left', function(){
        var type = $(this).attr('class');
        if (type == 'right'){
            ++num_count;
            if (num_count>total_count){ num_count = 1; $('figure').removeClass('setRedColor'); $('figure:first').addClass('setRedColor'); } else { $('.setRedColor').removeClass('setRedColor').next().addClass('setRedColor'); }
        } else {
            --num_count;
            if (num_count<1){ num_count = total_count; $('figure').removeClass('setRedColor'); $('figure').last().addClass('setRedColor'); } else { $('.setRedColor').removeClass('setRedColor').prev().addClass('setRedColor'); }
        }
    });

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

