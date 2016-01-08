<section class="video-block faq mg-top-17 mg-bottom-15">
    <main class="all" role="main">
        <div class="container <?=((count($pageArray)>0)?('video-caption'):(''));?>">
            <h1><a href="/review">ОТЗЫВЫ</a>
                <?php foreach ($pageArray as $data){ ?>
                    <?php if (!empty($data['url'])){?> <a href="/<?=$data['url'];?>"><?php } ?>
                    <span style="color: #b1b1b1;"><?=$data['name'];?></span>
                    <?php if (!empty($data['url'])){?> </a><?php } ?>
                <?php } ?>
            </h1>
        </div>
        <div class="container">

            <div class="main-content">

                <?php foreach ($model['element'] as $data) {
                    if ($data->status==0){continue;}
                    ?>

                    <article>
                        <div class="review_block">
                                <a href="#"><?=$data->author->name;?>
                                <span>/ <?=((!empty($data->review_data))?(date('d.m.Y', strtotime($data->review_data))):(date('d.m.Y', strtotime($data->created_at))));?></span></a>
                                <?=$data->review;?>
                        </div>
                    </article>

                <?php } ?>

            </div>



            <!-- справа -->
            <aside class="faq-right">

                <div class="col">
                    <?php
                        //Список категорий
                        foreach ($model['category'] as $dataCateg) {
                            if ($dataCateg->status==0){continue;}
                    ?>
                            <h3><a href="/review/<?=$dataCateg->url;?>" class="<?=$model['group']->id==$dataCateg->id?'active':'';?>"><?=$dataCateg->name;?><span>&ensp;(<?=ReviewElements::model()->getCountElements($dataCateg->id);?>)</span></a></h3>

                            <ul>
                                <?php
                                    if (isset($model['sub_category'][$dataCateg->id])) foreach ($model['sub_category'][$dataCateg->id] as $data){ ?>
                                    <li>
                                        <a class="<?=$model['group']->id==$data->id?'active':'';?>" href="<?=$data->url;?>">
                                            – <?=$data->name;?>
                                            <span>&ensp;(<?=ReviewElements::model()->getCountElements($data->id);?>)</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>

                    <?php } ?>
                </div>



                <form class="live" role="form" method="post">
                    <div class="form-group">
                        <label>Представьтесь пожалуйста</label>
                        <input name="AddReview[name]" class="form-control" id="sendFormName">
                    </div>
                    <div class="form-group">
                        <label>Ваше электронный адрес</label>
                        <input name="AddReview[email]" class="form-control" id="sendFormEmail">
                    </div>
                    <div class="form-group">
                        <label> </label>
                        <select name="AddReview[rubrics]" class="form-control" id="sendFormRubrics" >
                            <?php foreach ($model['select'] as $data) { ?>
                                <?php if ($data->status==0){continue;} ?>
                                <option value="<?=$data->id;?>" <?=(($data->id==$model['group']->id)?' selected ':'');?> ><?=($data->level==2)?'':(str_repeat('&nbsp;&nbsp;', $data->level)), $data->name?></option>
                            <?php } ?>
                        </select>
                        <?php /*<input class="form-control" placeholder="Выберите тему вопроса">*/ ?>
                    </div>
                    <div class="form-group">
                        <label>Здесь вы можете оставить ваш отзыв</label>
                        <textarea name="AddReview[review]" id="sendFormQuestion"></textarea>
                    </div>
                    <button class="btn btn-danger" id="sendFormFaq">отправить сообщение</button>
                </form>



            </aside>
    </main>
</section>
<script>
    $(document).on('click','.video-caption', function(){
        var url = '/<?php array_pop($pageArray); if (count($pageArray)>0){
        $url = end($pageArray);
       echo $url['url']; }  ?>';
        location.href = "/review"+url;
    });
</script>
