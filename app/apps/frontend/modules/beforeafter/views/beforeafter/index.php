<style>
    <?php foreach ($model['sub_group'] as $data) { ?>
    #carusel25_<?=$data->id;?>
    {
        height: 348px;
        text-align: center;
    }
    #carusel25_<?=$data->id;?> .carusel-right, #carusel25 .carusel-left
    {
        top: 134px;
    }
    #carusel25_<?=$data->id;?> .carusel-left
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
    #carusel25_<?=$data->id;?> .carusel-right
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
    <?php } ?>
</style>

<section class="after-before mg-top-17 x">
    <div class="container befor-iner ">
        <div class="container video-caption">
            <?php
            $parent_url = array();
            if (!empty($model['group'])){
                $modelTop = BeforeAfterRubrics::model()->findByPk($model['group']->id);
                $parent_url[] = ' / '.$model['group']->name;
                foreach ($modelTop->ancestors()->findAll('level>1') as $data){
                    $parent_url[] = ' / '.$data->name;
                }
            }
            rsort($parent_url);
            ?>
            <h1>ДО и ПОСЛЕ <?=(!empty($parent_url)?(implode("", $parent_url)):'');?></h1>
        </div>


        <?php $i = 1;?>
        <?php foreach ($model['sub_group'] as $data) { ?>

            <?php if(( $i%2!=0 )) { ?><div class="af-line"><?php } ?>
            <?php $modelImage = BeforeAfterElements::model()->find('parent_id='.$data->id.' ORDER BY on_main DESC'); ?>
            <div class="after" data-toggle="modal" <?php if ( $modelImage  ) { ?>data-target="#myModal-g<?=$data->id;?>" <?php } ?>>
                <?php
                    //Если нет дочерних категорий - выводим ссылку parent_id
                    //$link = '/beforeafter/'.$data->id;
                    $link = '#';
                    if ( $data->children()->findAll() ){
                        $link = Yii::app()->request->requestUri.'/'.$data->url;
                    }
                ?>
                <?php if($link!="#"){ ?>
                    <a href="<?=$link;?>" onclick="$(this).parent().removeAttr('data-toggle');"><?=$data->name;?></a>
                <?php } else { ?>
                    <span style="display: block;text-align: center;"><?=$data->name;?></span>
                <?php } ?>
                <span class="text-center block"><?=$data->description;?></span>
                <?php if ( $modelImage  ) { ?>
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

            <?php if(( $i%2==0 ) ) { ?></div><?php } ?>
            <?php ++$i; ?>
        <?php } ?>


    </div>

</section>





<?php foreach ($model['sub_group'] as $data) { ?>

<div class="modal fade myfade" id="myModal-g<?=$data->id;?>">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close-btn1" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-body">


                <div class="befor-meore">

                    <div id="carusel25_<?=$data->id;?>" class="owl-carousel owl-theme slider pos-relative mg-top-15">

                        <?php foreach (BeforeAfterElements::model()->findAll('parent_id='.$data->id) as $dataElement) { ?>
                            <?php
                                $url_before = '/uploads/filestorage/beforeafter/elements/medium2-before_'.$dataElement->id.'.'.$dataElement->before_photo;
                                $url_after = '/uploads/filestorage/beforeafter/elements/medium2-after_'.$dataElement->id.'.'.$dataElement->before_photo;
                            ?>
                        <div class="item">
                            <figure >
                                <h3><?=$dataElement->before_text;?></h3>
                                <a href="#">
                                    <img src="<?=$url_before;?>">
                                </a>
                                <a href="#">
                                    <img src="<?=$url_after;?>">
                                </a>
                                <h4><?=$dataElement->after_text;?></h4>
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

<script>

    <?php foreach ($model['sub_group'] as $data) { ?>
        $("#carusel25_<?=$data->id;?>").owlCarousel({
            items : 1, //10 изображений на 1000px
            itemsDesktop : [1000,1], //5 изображений на ширину между 1000px и 901px
            itemsDesktopSmall : [900,1], // 3 изображения между 900px и 601px
            itemsTablet: [600,1], //2 изображения между 600 и 0;
            itemsMobile : false,
            navigation : true
        });
    <? } ?>

</script>

