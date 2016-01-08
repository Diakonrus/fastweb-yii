<main class="all" role="main">
    <div class="container <?=((count($pageArray)>0)?('video-caption'):(''));?>">
        <h1><a href="/article">Статьи</a>
            <?php foreach ($pageArray as $data){ ?>
                <?php if (!empty($data['url'])){?> <a href="/<?=$data['url'];?>"><?php } ?>
                <span style="color: #b1b1b1;"><?=$data['name'];?></span>
                <?php if (!empty($data['url'])){?> </a><?php } ?>
            <?php } ?>
        </h1>
    </div>
</main>

<div class="container">

<?php foreach ($model as $data) { ?>
<b><a href="<?=Yii::app()->request->requestUri;?>/
<?=$data->url;?>">
        <?=$data->name;?> (
        <?=ArticleElements::model()->getCountElements($data->id);?>)</a></b>
    <ul>
    <?php
    $tmp_model = ArticleRubrics::model()->findByPk($data->id);
    foreach ($tmp_model->descendants()->findAll() as $dataSubRubrics) { ?>

        <li><a href="<?=Yii::app()->request->requestUri;?>/<?=$dataSubRubrics->url;?>"><?=$dataSubRubrics->name;?> (<?=ArticleElements::model()->getCountElements($dataSubRubrics->id);?>)</a></li>

    <?php } ?>
    </ul>
<?php } ?>

</div>


<?php
    if (!empty($modelElements)){
?>
<?php foreach ($modelElements as $data) { ?>

    <article>
        <div class="article_block">
            <a href="<?=Yii::app()->request->requestUri;?>/<?=$data->parent->url;?>/<?=$data->id;?>">
                <?=$data->name;?>
                <span>/ <?=(date('d.m.Y', strtotime($data->maindate)));?></span>
            </a>
            <div class="article_block_content">
                <?php
                if (!empty($data->image)){ ?>
                <div style="float:left;">
                    <img src="/uploads/filestorage/article/elements/small-<?=$data->id;?>.<?=$data->image;?>">
                </div>
                <?php }
                ?>
                <div style="padding-left: 120px;">
                <?=$data->brieftext;?>
                </div>
            </div>
        </div>
    </article>


<?php } ?>
<?php } ?>

<script>
    $(document).on('click','.video-caption', function(){
        var url = '/<?php array_pop($pageArray); if (count($pageArray)>0){
        $url = end($pageArray);
       echo $url['url']; }  ?>';
        location.href = "/article"+url;
    });
</script>