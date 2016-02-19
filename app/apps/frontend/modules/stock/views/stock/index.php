<div class="block_content">
    <div class="stock">
        <div class="page_name">
            <h1>Пресса</h1>
        </div>       

        <div>
            <br>
            <?php foreach ($model as $data){ ?>
            <div class="press">
               <figure>
                       <img alt="<?=$data->name;?>" src="/uploads/filestorage/stock/elements/small-<?=$data->id;?>.<?=$data->image;?>">                       
                </figure>
                <article>
                        <div style="color:#AB1129"><?=Press::model()->getDate($data->maindate);?></div>
                        <div class="press_name">
                             <a href="<?=Pages::returnUrl($data->id);?>"><?=$data->name;?></a>
                        </div>                        
                        <p >
                            <?=$data->brieftext;?>
                        </p>                          
                </article>                                  
            </div>
            <div class="clear"></div>
            <?php } ?>
        </div>
    </div>


</div>
