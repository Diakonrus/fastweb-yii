<div class="page_name"><h1>ВОПРОСЫ - ОТВЕТЫ</h1></div>

<div class="main-content">
    <!--  Рубрики список -->
    <div class="faq_cat">
        <?php foreach ($model['rubrics'] as $data) { ?>
                <div class="item">
                    <a href="<?=Yii::app()->request->requestUri;?>/<?=$data->url;?>"><?=$data->name;?></a>
                </div>
        <?php } ?>
    </div>
    <br />
    <!--  Элементы список -->
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