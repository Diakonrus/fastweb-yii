<div class="page_name">
    <h1>
        <h1>ВОПРОСЫ - ОТВЕТЫ</h1>
    </h1>
</div>

<div class="main-content">
    <!--  Рубрики -->
    <?php if(!empty($model['rubrics'])){ ?>
        <?php foreach ($model['rubrics'] as $data) { ?>
            <div class="faq_name_theam">
                <h1><a href="<?=Yii::app()->request->requestUri;?>/<?=$data->url;?>"><?=$data->name;?></a></h1>
            </div>

        <?php } ?>
    <?php } ?>

    <!--  Элемент -->
    <?php foreach ($model['elements'] as $data){ ?>
        <div class="question_item">
            <div class="autor_name">
                <b><?=$data->author->name;?></b> <?=date('d-m-Y',strtotime($data->author->created_at));?>
            </div>
            <div class="faq_name_theam"><?=$data->question;?></div>
            <a href="<?=Yii::app()->request->requestUri;?>/<?=$data->id;?>">Читать далее ...</a></br>
        </div>



    <?php } ?>








</div>