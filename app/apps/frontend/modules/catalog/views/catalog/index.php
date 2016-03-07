<?= $this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model)));  ?>

	<div class="menu_inside">
		<?php foreach ($catalogs as $data) { ?>
			<div class="menuinside item">
				<a  href="<?=$base_url;?>/<?=$data['url']?>"><?=$data['name'];?></a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>

<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>



<div class="tovar_container">
	<?php foreach ($elements as $data): ?>
		<?php $url_product = CatalogElements::model()->getProductUrl($data); ?>
		<div class="items-block-item">
			<a href="<?=$url_product;?>" class="items-block-item-img">
				<div class="rollover">
					<?php if ($data->shares==1){ ?>
						<div class="shares"></div>
					<?php } ?>
					<img src="<?= $data->getImageLink(); ?>" alt="">
				</div>
			</a>
			<div class="product_info_block">
				<a class="items-block-item-name" href="<?=$url_product;?>"><?=$data->name;?></a>
				<div class="item-price-count">
					<div class="items-block-item-price <?php if ($data->price_old > 0){ ?> old_price_active <?php } ?>"><span><?=$data->price;?> руб.</span></div>
					<?php if ($data->price_old > 0) { ?>
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
					   pic="<?=$data->getImageLink()?>"
					   price="<?=$data->price?>"
					   old_price="<?=$data->price_old;?>"
					   sales="<?php if ($data->shares==1){ ?>1<?php } ?>"
					>
						Заказать
					</a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>


<div class="panel panel-default paginator-panel">
  <div class="panel-body">
    <?$this->widget('CLinkPager', array('pages' => $pages));?>
  </div>
</div>

<?/*
<?=$filters?>
*/?>