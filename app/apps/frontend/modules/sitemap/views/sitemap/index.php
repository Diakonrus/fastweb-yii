<h2>Карта сайта</h2>

<ul class="sitemap_list">
<?php foreach ($sitemap as $val){ ?>

    <li>
        <a href="<?=$val['url'];?>"><?=$val['name'];?></a>
    </li>

<?php } ?>
</ul>