<main class="all" role="main">
    <div class="container">
        <h1>Отзывы</h1>
    </div>
</main>

<div class="main-content">

<!-- Темы отзывов -->
<?php foreach ($model['groups'] as $data) { ?>
<h4><a href="<?=Pages::returnUrl($data->url);?>"><?=$data->name;?> (<?=ReviewElements::model()->getCountElements($data->id);?>)</a></h4>
    <ul>
    <?php
    $tmp_model = ReviewRubrics::model()->findByPk($data->id);
    foreach ($tmp_model->descendants()->findAll() as $dataSubRubrics) { ?>

        <li><a href="<?=Pages::returnUrl($dataSubRubrics->url);?>"><?=$dataSubRubrics->name;?> (<?=ReviewElements::model()->getCountElements($dataSubRubrics->id);?>)</a></li>

    <?php } ?>
    </ul>
<?php } ?>

</div>

<HR>

<!-- отзывы оставленные ранее -->
<?php foreach ($model['elements'] as $data) { ?>
    <div class="review_block">
        <b><span class="author_review_name"><?=$data->author->name;?></span></b> - <span class="author_review_data"><?=(date('d.m.Y', strtotime($data->review_data)));?></span></br>

        <div class="review">
            <?php if ( !empty($data->brieftext) && (int)$param == 0 ) { ?>

                <p><?=$data->brieftext;?></p>
                </br>
                <a href="<?=Pages::returnUrl($data->id);?>">Читать далее...</a>

            <?php } else { ?>

                <p><?=$data->review;?></p>

            <?php } ?>

        </div>

    </div>

<?php } ?>

<HR>

<div class="form_add_review">
    <?php echo $this->renderPartial('_form', array('modelAuthor'=>new ReviewAuthor(), 'modelReview'=>new ReviewElements())); ?>
</div>