<main class="all" role="main">
    <div class="container video-caption">
        <h1>ВОПРОСЫ - ОТВЕТЫ</h1>
    </div>
</main>


<div class="main-content">
    <!--  Рубрики -->
    <?php if(!empty($model['rubrics'])){ ?>
        <div class="faq_name_theam">
            <h1><a href="<?=Yii::app()->request->requestUri;?>/<?=$model['rubrics']->url;?>"><?=$model['rubrics']->name;?></a></h1>
        </div>
    <?php } ?>

    <!--  Элемент -->

    <div class="autor"><?=$model['elements']->author->name;?></div> / <div class="email"><?=$model['elements']->author->email;?></div> / <div class="date"><?=date('d-m-Y',strtotime($model['elements']->author->created_at));?></div>
    <div class="question"><h3><?=$model['elements']->question;?></h3></div></br>
    <div class="answer"><h3><?=$model['elements']->answer;?></h3></div></br>
    <HR>



</div>