<main class="all" role="main">
    <div class="container video-caption">
        <h1>Отзывы</h1>
    </div>
</main>

<div class="main-content">

<?php foreach ($model as $data) { ?>
<h4><a href="<?=Yii::app()->request->requestUri;?><?=$data->url;?>"><?=$data->name;?> (<?=ReviewElements::model()->getCountElements($data->id);?>)</a></h4>
    <ul>
    <?php
    $tmp_model = ReviewRubrics::model()->findByPk($data->id);
    foreach ($tmp_model->descendants()->findAll() as $dataSubRubrics) { ?>

        <li><a href="<?=Yii::app()->request->requestUri;?>/<?=$dataSubRubrics->url;?>"><?=$dataSubRubrics->name;?> (<?=ReviewElements::model()->getCountElements($dataSubRubrics->id);?>)</a></li>

    <?php } ?>
    </ul>
<?php } ?>

</div>