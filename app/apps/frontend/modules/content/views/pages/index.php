<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=$model->title?></h1>

<div>
<?=$model->content;?>
</div>

<?=$modelTabs;?>


<!-- ¬ывожу товары если они помечены на главную -->
<?php if (!empty($modelCatalog)) { ?>
    <ul>
    <?php foreach ($modelCatalog as $data) { ?>

        <li>
            <img src="/uploads/filestorage/catalog/elements/medium-<?=$data->id;?>.<?=$data->image;?>" />
        </li>

    <?php } ?>
    </ul>
<?php } ?>