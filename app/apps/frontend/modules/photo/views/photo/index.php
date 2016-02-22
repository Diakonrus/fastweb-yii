<div class="page_title">
    <h1>Фотогалерея</h1>
</div>


<?php if (!empty($model)){ ?>
    <?php foreach ($model as $data) { ?>
        <div class="photo_block">
            <a href="<?=Pages::returnUrl($data->url);?>">
            <?php if (!empty($data->image)) { ?>
                    <img src="/uploads/filestorage/photo/rubrics/medium-<?=$data->id;?>.<?=$data->image;?>">
                <?php } ?>
            <div class="photo_block_content">

                    <?=$data->name;?> (
                    <?=PhotoElements::model()->getCountElements($data->id);?>)
            </div>
            </a>

        </div>
    <?php } ?>
<?php } ?>

<?php
if (!empty($modelElements)){
    ?>
    <?php foreach ($modelElements as $data) { ?>

        <div class="photo_block">           
                <a href="/uploads/filestorage/photo/elements/<?=$data->id;?>.<?=$data->image;?>" class="fancybox" data-fancybox-group="group">
                    
                    <?php if (!empty($data->image)) { ?>
                       <img src="/uploads/filestorage/photo/elements/medium-<?=$data->id;?>.<?=$data->image;?>">
                    <?php } ?>

                
                <div class="photo_block_content">

                    <?php
                    if (!empty($data->name)){ ?>                        
                            <?=$data->name;?>                        
                    <?php }
                    ?>
                </div>     
              </a>         
        </div>


    <?php } ?>
<?php } ?>
