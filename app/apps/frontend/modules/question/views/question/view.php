<section class="video-block faq mg-top-17 mg-bottom-15">
    <main class="all" role="main">
        <div class="container video-caption">
            <h1>
                ОТВЕТЫ
                <?php
                    $parent_url = array();
                    $modelTop = FaqRubrics::model()->findByPk($model['group']->id);
                    foreach ($modelTop->ancestors()->findAll('level!=1') as $data){
                        if ($data->status==0){continue;}
                        echo '
                        <span>
                            /
                            <a href="/question/'.$data->url.'">'.$data->name.'</a>
                        </span>
                        ';
                        $parent_url[] = $data->url;
                    }
                ?>
                <span>
                    /
                    <a href="/question/<?=(!empty($parent_url)?(implode("/", $parent_url)):'');?>/<?=$model['group']->url;?>"><?=$model['group']->name;?></a>
                </span>
            </h1>
        </div>
        <div class="container">

            <div class="main-content">

                <?php foreach ($model['element'] as $data) {
                    if ($data->status==0){continue;}
                    ?>

                    <article>
                        <div class="question">
                                <a href="#"><?=$data->author->name;?>
                                <span>/ <?=date('d.m.Y', strtotime($data->created_at));?></span></a>
                                <?=$data->question;?>
                        </div>
                        <?php if (!empty($data->answer)) { ?>
                        <div class="unswer">
                            <?=$data->answer;?>
                        </div>
                        <?php } ?>
                    </article>

                <?php } ?>

            </div>



            <!-- справа -->
            <aside class="faq-right">

                <form role="form">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input id="appendedInputButton-02" class="form-control" type="search" placeholder="Фамилия врача / процедура">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="fui-search"></span>
                            </button>
                            </span>
                        </div>
                    </div>
                </form>



                <div class="col">
                    <?php
                        //Список категорий
                        foreach ($model['category'] as $dataCateg) {
                            if ($dataCateg->status==0){continue;}
                    ?>
                            <h3><a href="/question/<?=$dataCateg->url;?>" class="<?=$model['group']->id==$dataCateg->id?'active':'';?>"><?=$dataCateg->name;?><span>&ensp;(<?=FaqElements::model()->getCountElements($dataCateg->id);?>)</span></a></h3>

                            <ul>
                                <?php
                                    if (isset($model['sub_category'][$dataCateg->id])) foreach ($model['sub_category'][$dataCateg->id] as $data){ ?>
                                    <li>
                                        <a class="<?=$model['group']->id==$data->id?'active':'';?>" href="<?=$data->url;?>">
                                            – <?=$data->name;?>
                                            <span>&ensp;(<?=FaqElements::model()->getCountElements($data->id);?>)</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>

                    <?php } ?>
                </div>



                <form class="live" role="form" method="post">
                    <div class="form-group">
                        <label>Представьтесь пожалуйста</label>
                        <input name="AddQuestion[name]" class="form-control" id="sendFormName">
                    </div>
                    <div class="form-group">
                        <label>Ваше электронный адрес</label>
                        <input name="AddQuestion[email]" class="form-control" id="sendFormEmail">
                    </div>
                    <div class="form-group">
                        <label> </label>
                        <select name="AddQuestion[rubrics]" class="form-control" id="sendFormRubrics" >
                            <?php foreach ($model['select'] as $data) { ?>
                                <?php if ($data->status==0){continue;} ?>
                                <option value="<?=$data->id;?>" <?=(($data->id==$model['group']->id)?' selected ':'');?> ><?=($data->level==2)?'':(str_repeat('&nbsp;&nbsp;', $data->level)), $data->name?></option>
                            <?php } ?>
                        </select>
                        <?php /*<input class="form-control" placeholder="Выберите тему вопроса">*/ ?>
                    </div>
                    <div class="form-group">
                        <label>Здесь вы можете задать ваш вопрос</label>
                        <textarea name="AddQuestion[question]" id="sendFormQuestion"></textarea>
                    </div>
                    <button class="btn btn-danger" id="sendFormFaq">отправить сообщение</button>
                </form>



            </aside>
    </main>
</section>

