<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<h1 class="lined nopaddingtop" style="margin-top: 10px;">Каталог продукции</h1>

<div class="menu_inside">
	<?php foreach ($catalogs as $data) { ?>
		<div class="menuinside item">
			<a  href="<?=$base_url;?>/<?=$data['url']?>"><?=$data['name'];?></a>
		</div>
	<?php } ?>
	<div class="clear"></div>
</div>



<div class="tovar_container">
<?php foreach ($elements as $data){
	$url_product = $base_url.CatalogElements::model()->getProductUrl($data);

	$url_img = '/images/nophoto_100_100.jpg';
	$filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/medium-'.$data->id.'.'.$data->image;
	if (file_exists($filename))
	{
		$url_img = '/uploads/filestorage/catalog/elements/medium-'.$data->id.'.'.$data->image;
	}


	$name_noqoutes = $data->name;
	$name_noqoutes = str_replace("'",'',$name_noqoutes);
	$name_noqoutes = str_replace('"','',$name_noqoutes);
	$name_noqoutes = htmlspecialchars($name_noqoutes,ENT_QUOTES);
	$name_noqoutes = str_replace('&#039;','',$name_noqoutes);

	?>
	<div class="items-block-item">
		<a href="<?=$url_product;?>" class="items-block-item-img">
			<div class="rollover">
				<?php if ($data->shares==1){ ?>
					<div class="shares"></div>
				<?php } ?>
				<img src="<?=$url_img?>" alt="">
			</div>
		</a>
		<div class="product_info_block">
			<a class="items-block-item-name" href="<?=$url_product;?>"><?=$data->name;?></a>
			<div class="item-price-count">
				<div class="items-block-item-price <?php if ($data->price_old > 0){ ?> old_price_active <?php } ?>"><span><?=$data->price;?> руб.</span></div>
				<?php if ($data->price_old > 0){ ?>
					<div class="old_price_product_cat">
						<span><?=$data->price_old;?> руб.</span>
					</div>
				<?php } ?>


				<div class="item-count-area">
					<a href="" class="item-count-inc"></a>
					<input value="1" class="item-count" type="text">
					<a href="" class="item-count-dec"></a>
				</div>


				<div class="clear"></div>
			</div>

			<div class="order_one_click">
				<a href="javascript:void(0)"
				   class="fastorder"
				   idx="<?=$data->id;?>"
				   names="<?=$data->name;?>"
				   pic="<?=$url_img?>"
				   price="<?=$data->price?>"
				   old_price="<?=$data->price_old;?>"
				   sales="<?php if ($data->shares==1){ ?>1<?php } ?>"
				>

					Заказать
				</a>
			</div>
		</div>



	</div>
<?php } ?>
	</div>
	

<div class="panel panel-default paginator-panel">
  <div class="panel-body">
    <?$this->widget('CLinkPager', array('pages' => $pages));?>
  </div>
</div>

<?/*
<?=$filters?>
*/?>