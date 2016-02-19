<div class="page_name">
    <h1>ВОПРОСЫ - ОТВЕТЫ</h1>
</div>


<div class="main-content">
    <!--  Рубрики -->
    <?php if(!empty($model['rubrics'])){ ?>
        <div class="faq_name_theam">
            <h1><a href="<?=Yii::app()->request->requestUri;?>/<?=$model['rubrics']->url;?>"><?=$model['rubrics']->name;?></a></h1>
        </div>
    <?php } ?>

    <!--  Элемент -->
    <div class="question_item">
         <div class="autor_name">
                <b><?=$model['elements']->author->name;?></b> <?=date('d-m-Y',strtotime($model['elements']->author->created_at));?>
                 <div class="question"><?=$model['elements']->question;?></div>
                <div class="answer">Ответ: <p></p><?=$model['elements']->answer;?></div></br>
        </div>
    </div> 



</div>