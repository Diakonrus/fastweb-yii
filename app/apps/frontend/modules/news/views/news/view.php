<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1>НОВОСТИ</h1>
        </div>
    </main>
    <div class="news-block">
        <main role="main" class="all">
            <div class="container news-all">
                <figure>
                    <?php

                        if (!empty($model->image)){
                            echo '<img src="/uploads/filestorage/news/elements/small-'.$model->id.'.'.$model->image.'">';
                        }

                    ?>
                </figure>
                <article>
                    <p><?php echo News::model()->getDate($model->maindate);?></p>
                    <blockquote>
                        <?php echo $model->name; ?>
                    </blockquote>
                        <?php echo $model->description; ?>
                </article>
            </div>
        </main>
    </div>

</section>
