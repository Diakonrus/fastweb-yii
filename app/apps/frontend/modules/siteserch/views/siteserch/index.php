<section>
    <main role="main" class="all">
        <div class="container video-caption">
            <h1>РЕЗУЛЬТАТЫ ПОИСКА</h1>
        </div>
    </main>
</section>
<section>
    <main class="all gray-f" role="main">
        <div class="container news-all">

            <?php if (empty($model)){ ?>
                <h2>Ничего не найдено по запросу.</h2>
            <?php } else { ?>
            <ul style="padding-top: 10px; padding-bottom: 10px;">
                <?php foreach ($model as $url=>$name) { ?>
                    <li><a href="/<?=$url;?>"><?=$name;?></a></li>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
    </main>
</section>