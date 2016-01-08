<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1><a href="/aktsii">АКЦИИ</a>
                <?php foreach ($model['page'] as $val){ ?>
                    <a href="/aktsii/<?=$val['url'];?>"><span style="color: #b1b1b1;"> / <?=$val['name'];?></span></a>
                <?php } ?>
                <?php if (is_numeric($param_url)){ ?>
                    <span style="color: #b1b1b1;"> / <?=current($model['elements'])->name;?></span>
                <?php } ?>
            </h1>
        </div>
    </main>
    <div class="news-block">
        <main role="main" class="all">
            <?php if(!empty($model['group'])){ ?>
                <div class="container news-all">
                    <?=$model['group']->description;?>
                </div>
            <?php } ?>

            <?php if (!empty($model['elements'])){?>
            <div class="container news-all">
                <?php foreach ($model['elements'] as $data){?>
                    <figure>
                        <?php

                        if (!empty($data->image)){
                            echo '<img src="/uploads/filestorage/sale/elements/small-'.$data->id.'.'.$data->image.'">';
                        }

                        ?>
                    </figure>
                    <article>
                        <p><?php echo Sale::model()->getDate($data->maindate);?></p>
                        <blockquote>
                            <?php if(!empty($model['group'])){ ?><a href="<?=Yii::app()->request->requestUri;?>/<?=$data->id;?>"><?php echo $data->name; ?></a><?php } else { ?>
                                <h5><?=$data->name;?></h5>
                            <?php } ?>
                        </blockquote>
                        <?php echo (!empty($model['group']))?($data->brieftext):($data->description); ?>
                    </article>
                <?php } ?>
            </div>
            <?php } ?>
        </main>
    </div>

</section>
<script>
    $(document).on('click','.video-caption', function(){
        history.back();
    });
</script>