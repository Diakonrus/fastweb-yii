<style>
    #carusel25
    {
        height: 348px;
        text-align: center;
    }
    #carusel25 .carusel-right, #carusel25 .carusel-left
    {
        top: 134px;
    }
    #carusel25 .carusel-left
    {
        left: 0;
        background-color: #fff;
        background-size: inherit;
        background-position: 20px 50%;
        /* border: 1px solid red; */
        top: 0;
        bottom: 0;
        height: auto;
        width: 103px;}
    #carusel25 .carusel-right
    {
        right:0;
        background-color: #fff;
        background-size: inherit;
        background-position: 42px 50%;
        /* border: 1px solid red; */
        top: 0;
        bottom: 0;
        height: auto;
        width: 103px;;
    }
</style>

<section class="after-before mg-top-17 x">
    <div class="container befor-iner ">
        <div class="container video-caption">
            <?php
            $parent_url = array();
            if (!empty($model['group'])){
                $modelTop = BeforeAfterRubrics::model()->findByPk($model['group']->id);
                $parent_url[0]['name'] = ' / '.$model['group']->name;
                $parent_url[0]['url'] = null;
                $i = 1;
                foreach ($modelTop->ancestors()->findAll('level>1') as $data){
                    $parent_url[$i]['name'] = ' / '.$data->name;
                    $parent_url[$i]['url'] = 'beforeafter/'.$data->url;
                    ++$i;
                }
            }
            rsort($parent_url);
            ?>
            <h1><a href="/beforeafter">ДО и ПОСЛЕ</a>
                <?php foreach ($parent_url as $data) { ?>
                        <?php if (!empty($data['url'])){?> <a href="/<?=$data['url'];?>"><?php } ?>
                        <span style="color: #b1b1b1;"><?=$data['name'];?></span>
                        <?php if (!empty($data['url'])){?> </a><?php } ?>
                <?php } ?>
            </h1>
        </div>

        <center>
        <?php $i=0; foreach ( $model['elements'] as $data ){ ++$i; ?>

            <?php
            $url_before = '/uploads/filestorage/beforeafter/elements/medium-before_'.$data->id.'.'.$data->before_photo;
            $url_after = '/uploads/filestorage/beforeafter/elements/medium-after_'.$data->id.'.'.$data->before_photo;
            ?>

            <div class="after row_<?=$data->id;?>" data-id="<?=$i;?>"  data-toggle="modal" data-target="#myModal-g" style="margin-bottom:100px;"
                 onclick="var id=$(this).data('id');goTo(id);">
                    <figure>
                        <div style="
                            background: url(<?=$url_before;?>) no-repeat center top;
                            width: 100%;
                            height: 100%;
                            overflow: hidden;
                            ">
                        </div>
                        <figcaption> ДО </figcaption>
                    </figure>
                    <figure>
                        <div style="
                            background: url(<?=$url_after;?>) no-repeat center top;
                            width: 100%;
                            height: 100%;
                            overflow: hidden;
                            ">
                        </div>
                        <figcaption> ПОСЛЕ </figcaption>
                    </figure>

                <center>
                    <div style="margin-top: 20px;">
                        <?=$data->before_text;?>
                    </div>
                </center>

            </div>
            <div style="clear: both;"></div>
        <?php } ?>
        </center>


    </div>

</section>


<?php if (!empty($model['elements'])) { ?>
<div class="modal fade myfade" id="myModal-g">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close-btn1" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-body">


                <div class="befor-meore">

                    <div id="carusel25" class="owl-carousel owl-theme slider pos-relative mg-top-15">

                        <?php foreach ($model['elements'] as $dataElement) { ?>
                            <?php
                            $url_before = '/uploads/filestorage/beforeafter/elements/medium2-before_'.$dataElement->id.'.'.$dataElement->before_photo;
                            $url_after = '/uploads/filestorage/beforeafter/elements/medium2-after_'.$dataElement->id.'.'.$dataElement->before_photo;
                            ?>

                            <div style="margin-top: 300px;position: absolute; background-color: rgba(255, 255, 255, 0.2); height: 50px; width:100%;">
                            </div>
                            <p style="margin-top: 305px;position: absolute; margin-left:240px; ">ДО</p>
                            <p style="margin-top: 305px;position: absolute; margin-left: 700px;">ПОСЛЕ</p>

                            <div class="item">
                                <figure >
                                    <h3><?=$dataElement->before_text;?></h3>

                                    <a href="#">
                                        <img src="<?=$url_before;?>">
                                    </a>
                                    <a href="#">
                                        <img src="<?=$url_after;?>">
                                    </a>
                                </figure>
                            </div>
                        <?php } ?>

                    </div>

                </div>



            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php } ?>


<script src='http://owlgraphic.com/owlcarousel/owl-carousel/owl.carousel.js'></script>
<script>
    $("#carusel25").owlCarousel({
        items : 1, //10 изображений на 1000px
        itemsDesktop : [1000,1], //5 изображений на ширину между 1000px и 901px
        itemsDesktopSmall : [900,1], // 3 изображения между 900px и 601px
        itemsTablet: [600,1], //2 изображения между 600 и 0;
        itemsMobile : false,
        navigation : true
    });
    var owl = $("#carusel25").data('owlCarousel');

    function goTo(id){
        var inputVal = id;
        $('.owl-wrapper').trigger('owl.goTo', inputVal-1);
    };
    $(document).on('click','.video-caption', function(){
        var url = '/<?php array_pop($parent_url);
        if (count($parent_url)>0){
        $url = end($parent_url);
        echo $url['url']; }  ?>';
        location.href = "/beforeafter"+url;
    });
</script>
