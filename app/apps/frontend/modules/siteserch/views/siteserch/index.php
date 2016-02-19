<?

$this->pageTitle = 'Поиск на сайте '.$_SERVER['HTTP_HOST'];
?>


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
            <?php if (empty($model_elements)){ ?>
                <h2>Ничего не найдено по запросу.</h2>
            <?php } else { ?>
        </div>
    </main>




<div class="tovar_container">
<?php 
$i=0;
foreach ($model_elements as $data){ 
	$i++;
	//echo 'i = '.$i.'<br>';
	if (($i<=$page*12)||($i>($page+1)*12))
	{
		//echo 'continue<br>';
		continue;
	}
$element = CatalogElements::model()->getProduct($data->id);
if (isset($element['url']))
{
	$url = '/catalog'.$element['url'].'/'.$data->id;
}
	
		$url_img = '/images/nophoto_100_100.jpg';
		$filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/'.$data->id.'.'.$data->image;
		if (file_exists($filename))
		{ 
			$url_img = '/uploads/filestorage/catalog/elements/'.$data->id.'.'.$data->image; 
		}


$name_noqoutes = $data->name;
$name_noqoutes = str_replace("'",'',$name_noqoutes);
$name_noqoutes = str_replace('"','',$name_noqoutes);
$name_noqoutes = htmlspecialchars($name_noqoutes,ENT_QUOTES);
$name_noqoutes = str_replace('&#039;','',$name_noqoutes);

	?>
	<div class="items-block-item">
		<a href="<?=$url;?>" class="items-block-item-img">
			<table>
				<tr><td></td></tr>
				<tr><td><img src="<?=$url_img?>" alt=""></td></tr>
				<tr><td></td></tr>
			</table>
		</a>
		<a class="items-block-item-name" href="<?=$url;?>"><?=$data->name;?></a>
		<div class="items-block-item-price"><?=$data->price;?> руб.</div>
		<a class="buy-btn" href="javascript:void(0);" onclick="SupposeInBasket('catalog/<?=$data->id;?>', 'catalog', 'price','<?=$data->id;?>','<?=$name_noqoutes;?>',0,1,'','','','1');">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="javascript:void(0)" class="fastorder" idx="<?=$data->id;?>">Заказать в 1 клик</a>
		</div>
	</div>
<?php 


} ?>
	</div>


            
            <?php } ?>

    
<?if (isset($pages)):?>
<div class="panel panel-default paginator-panel">
  <div class="panel-body">
    <?$this->widget('CLinkPager', array('pages' => $pages));?>
  </div>
</div>
<?endif;?>
    
</section>
