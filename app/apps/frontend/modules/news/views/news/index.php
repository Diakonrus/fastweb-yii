<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>

<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>

    <!-- Выводим новости без групп -->
    <section>
        <div class="news-block">
            <main role="main" class="all">
                <div class="">
                    <?php $i = 0; ?>
                    <?php foreach ( $modelElements as $elements ) { ?>
                        <?php ++$i;?>
                        <?php if ($i%2!=0){ echo '<div class="press-line">'; }?>
                            <div class="press">
                                <figure>
                                    <img src="<?= $elements->getImageLink(); ?>" alt="" />
                                </figure>
                                <article>
                                    <span><?= date("d.m.Y", strtotime($elements->maindate)); ?></span>
                                    <h1>
                                        <a href="<?= Yii::app()->request->requestUri.'/'.$elements->id ?>"><?= $elements->name ?></a>
                                    </h1>
                                    <?= $elements->brieftext; ?>
                                </article>
                            </div >
                        <?php if ($i%2!=0){ echo '</div>'; }?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </section>
