<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1>НОВОСТИ</h1>
        </div>
    </main>
</section>

    <!-- Выводим группы новостей -->
    <?php foreach ( $model['group'] as $data ) { ?>
        <?=NewsGroup::model()->returnDesignGroup($data);?>
    <?php } ?>


    <!-- Выводим новости без групп -->
    <section>
        <div class="news-block">
            <main role="main" class="all">
                <div class="container news-all">
                    <?php $i = 0; ?>
                    <?php foreach ( $model['no_group'] as $data ) { ?>
                        <?php ++$i;?>
                        <?php if ($i%2!=0){ echo '<div class="press-line">'; }?>
                            <?=NewsGroup::model()->returnDesignElement($data);?>
                        <?php if ($i%2==0){ echo '</div>'; }?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </section>
