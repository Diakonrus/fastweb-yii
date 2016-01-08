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
        <div class="container <?=(isset($model['group']) && !empty($model['group']))?('video-caption'):('');?>">
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
            <h1><a href="/beforeafter">ДО и ПОСЛЕ</a><span style="color: #b1b1b1;"><?=(!empty($parent_url)?(implode("", $parent_url)):'');?></span></h1>
        </div>


        <?php $i = 1;?>
        <?php foreach ($model['sub_group'] as $data) { ?>

            <?php if(( $i%2!=0 )) { ?><div class="af-line"><?php } ?>
            <?php $modelImage = BeforeAfterElements::model()->find('parent_id='.$data->id.' ORDER BY on_main DESC'); ?>
            <div class="after" data-toggle="modal" <?php if ( $modelImage  ) { ?>data-target="#myModal-g<?=$data->id;?>" <?php } ?>>
                <?php
                    //Если нет дочерних категорий - выводим ссылку parent_id
                    $link = Yii::app()->request->requestUri.'/'.$data->url;
                    /*
                    if ( $data->children()->findAll() ){
                        $link = Yii::app()->request->requestUri.'/'.$data->url;
                    }
                    */
                ?>
                <a href="<?=$link;?>" onclick="$(this).parent().removeAttr('data-toggle');"><?=$data->name;?></a>
                <span class="text-center block"><?=$data->description;?></span>
                <?php if ( $modelImage  ) { ?>
                <?php
                    $url_before = '/uploads/filestorage/beforeafter/elements/medium-before_'.$modelImage->id.'.'.$modelImage->before_photo;
                    $url_after = '/uploads/filestorage/beforeafter/elements/medium-after_'.$modelImage->id.'.'.$modelImage->before_photo;
                ?>
                <a href="<?=$link;?>">
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
                    <figcaption> ПОСЛЕ </figcaption>
                </figure>
                </a>
                <?php } ?>
            </div>

            <?php if(( $i%2==0 ) ) { ?></div><?php } ?>
            <?php ++$i; ?>
        <?php } ?>


    </div>

</section>


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

    $(document).on('click','.video-caption', function(){
        var url = '/<?php array_pop($parent_url);
        if (count($parent_url)>0){
        $url = end($parent_url);
        echo $url['url']; }  ?>';
        location.href = "/beforeafter"+url;
    });
</script>

