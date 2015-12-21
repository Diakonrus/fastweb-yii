<div class="container">
    <div class="top-text">
        <?php
            //Получаем содержимое страницы врачей
            $module = SiteModule::model()->find('url_to_controller LIKE "/doctor/doctor"');
            if (!empty($module) && $page = Pages::model()->find('type_module='.$module->id.' AND `status`=2')){ ?>
                <?=$page->content;?>
            <?php } ?>
    </div>
</div>


<?php foreach ($model['group'] as $data){ ?>

    <div class="container top-text">
        <h1 class="text-center"><?=$data->name;?></h1>
    </div>
    <div class="container doctor-block">
        <?php foreach ( $model['element'][$data->id] as $dataElements ) { ?>

            <div class="doctor">
                <figure>
                    <?php if (!empty($dataElements->image)) { ?><img src="/uploads/filestorage/doctor/elements/medium-<?=$dataElements->id;?>.<?=$dataElements->image;?>" data-toggle="modal" data-target="#myModal<?=$dataElements->id;?>"><?php } ?>
                </figure>
                <h1>
                    <a data-toggle="modal" data-target="#myModal<?=$dataElements->id;?>" href="#">
                        <?=$dataElements->name;?>
                    </a>
                </h1>
                <article class="text-center">
                    <?=$dataElements->anonse;?>
                </article>
            </div>

            <div id="myModal<?=$dataElements->id;?>" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button class="close-btn1" aria-hidden="true" data-dismiss="modal" type="button">×</button>
                        <div class="modal-body">
                            <div class="shadow-doc">
                                <figure class="big-dctor">
                                    <?php if (!empty($dataElements->image)) { ?><img src="/uploads/filestorage/doctor/elements/medium-<?=$dataElements->id;?>.<?=$dataElements->image;?>"><?php } ?>
                                    <figcaption class="text-center">
                                        <?=$dataElements->anonse;?>
                                        <hr>
                                        <?=$dataElements->anonse_dop;?>
                                    </figcaption>
                                </figure>
                                <article class="big-dctor-text">
                                    <h1><?=$dataElements->name;?></h1>
                                    <blockquote class="cite">
                                        Специализация.&ensp;
                                        <?php
                                            //Получаем все специализации врача
                                            foreach ($model['spec'][$dataElements->id] as $dataSpec){
                                        ?>
                                                <?=$dataSpec['name'];?>.&ensp;
                                            <?php
                                            }
                                        ?>
                                    </blockquote>
                                    <?=$dataElements->description;?>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>


    </div>
<?php } ?>