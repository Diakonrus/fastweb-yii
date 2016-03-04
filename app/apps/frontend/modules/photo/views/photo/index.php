<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>

        <div class="menu_inside">
            <?php foreach ($menu_top as $id=>$data) { ?>
                <div class="menuinside item">
                    <a class="<?=($param->id==$id?'active':'');?>" href="/photo/<?=$data['url']?>"><?=$data['name'];?></a>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        


<h1 class="lined nopaddingtop"><?=Pages::getTitle()?></h1>




       




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
        <div class="container news-all photo gallery">

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
                    $images_image_full = '/images/nophoto.jpg';
                    if (!empty($data->image)){
                        //Есть картинка раздела - ставим ее
                        $images_image = "/uploads/filestorage/photo/elements/medium-" . $data->id . "." . $data->image;
                        $images_image_full = "/uploads/filestorage/photo/elements/" . $data->id . "." . $data->image;
                    }
                    ?>

					<div class="img">
						<a class="group" href="<?=$images_image_full;?>" title="" rel="gallery-2">
							<img src="<?=$images_image;?>">
						</a>
					</div>
                 

                <?php } ?>


            <?php } ?>


        </div>
    </main>
</div>

