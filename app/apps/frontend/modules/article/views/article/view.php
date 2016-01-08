<main class="all" role="main">
    <div class="container video-caption">
        <h1><a href="/article">Статьи</a>
            <?php foreach ($pageArray as $data){ ?>
                <?php if (!empty($data['url'])){?> <a href="/<?=$data['url'];?>"><?php } ?>
                <span style="color: #b1b1b1;"><?=$data['name'];?></span>
                <?php if (!empty($data['url'])){?> </a><?php } ?>
            <?php } ?>
        </h1>
    </div>
</main>


<?php
if (!empty($modelElements)){
    ?>

        <article>
            <div class="article_block">
                <a href="<?=Yii::app()->request->requestUri;?>/<?=$modelElements->parent->url;?>/<?=$modelElements->id;?>">
                    <?=$modelElements->name;?>
                    <span>/ <?=(date('d.m.Y', strtotime($modelElements->maindate)));?></span>
                </a>
                <div class="article_block_content">
                    <?php
                    if (!empty($modelElements->image)){ ?>
                        <div style="float:left;">
                            <img src="/uploads/filestorage/article/elements/small-<?=$modelElements->id;?>.<?=$modelElements->image;?>">
                        </div>
                    <?php }
                    ?>
                    <div style="padding-left: 120px;">
                        <?=$modelElements->description;?>
                    </div>
                </div>
            </div>
        </article>

<?php } ?>

<script>
    $(document).on('click','.video-caption', function(){
        var url = '/<?php array_pop($pageArray); if (count($pageArray)>0){
        $url = end($pageArray);
       echo $url['url']; }  ?>';
        location.href = "/article"+url;
    });
</script>
