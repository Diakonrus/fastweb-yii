<main class="all" role="main">
    <div class="container video-caption">
        <h1>ВОПРОСЫ - ОТВЕТЫ</h1>
    </div>
</main>

<div class="main-content">

<?php foreach ($model as $data) { ?>
<h4><a href="<?=Yii::app()->request->requestUri;?><?=$data->url;?>"><?=$data->name;?> (<?=FaqElements::model()->getCountElements($data->id);?>)</a></h4>
    <ul>
    <?php
    $tmp_model = FaqRubrics::model()->findByPk($data->id);
    foreach ($tmp_model->descendants()->findAll() as $dataSubRubrics) { ?>

        <li><a href="<?=Yii::app()->request->requestUri;?><?=$dataSubRubrics->url;?>"><?=$dataSubRubrics->name;?> (<?=FaqElements::model()->getCountElements($dataSubRubrics->id);?>)</a></li>

    <?php } ?>
    </ul>
<?php } ?>

</div>