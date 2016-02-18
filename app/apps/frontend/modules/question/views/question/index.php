<main class="all" role="main">
    <div class="container video-caption">
        <h1>ВОПРОСЫ - ОТВЕТЫ</h1>
    </div>
</main>

<div class="main-content">
<!--  Рубрики список -->
<?php foreach ($model['rubrics'] as $data) { ?>

    <div class="faq_name_theam">
        <h1><a href="<?=Yii::app()->request->requestUri;?>/<?=$data->url;?>"><?=$data->name;?></a></h1>
    </div>

<?php } ?>

<!--  Элементы список -->
<?php foreach ($model['elements'] as $data){ ?>

    <div class="faq_name_theam"><h1><?=$data->question;?></h1></div></br>
    <a href="<?=Yii::app()->request->requestUri;?>/<?=$data->id;?>">Читать далее ...</a></br>

<?php } ?>

</div>