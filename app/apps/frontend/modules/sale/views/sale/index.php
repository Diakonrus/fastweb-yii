<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1>АКЦИИ</h1>
        </div>
    </main>
</section>

    <!-- Выводим группы акций -->
    <?php foreach ( $model['group'] as $data ) { ?>
        <?=SaleGroup::model()->returnDesignGroup($data);?>
    <?php } ?>


    <!-- Выводим акции без групп -->
    <section>
        <div class="news-block">
            <main role="main" class="all">
                <div class="container news-all">
                    <?php $i = 0; ?>
                    <?php foreach ( $model['no_group'] as $data ) { ?>
                        <?php ++$i;?>
                        <?php if ($i%2!=0){ echo '<div class="press-line">'; }?>
                            <?=SaleGroup::model()->returnDesignElement($data);?>
                        <?php if ($i%2==0){ echo '</div>'; }?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </section>
