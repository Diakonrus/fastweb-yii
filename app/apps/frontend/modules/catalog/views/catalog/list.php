<?=$this->widget('application.apps.frontend.components.Categories',array('params'=>array($modelRubric->id)), TRUE)?>

<div class="items-block-bestsallers" style="margin-top: 0px;">
	<h1 style="text-align: center; font-size: 24px;"><?=$modelRubric->name;?></h1>
	
	
<?
/*
$all = CatalogRubrics::model()->findAll('parent_id='.$modelRubric->id);
foreach ($all as $item)
{
	$item_attributes = $item->getAttributes();
	echo '<li><a href="/catalog/'.$item_attributes['url'].'">'.$item_attributes['name'].'</a>';
}
*/
?>


	
	<div class="tovar_container">
		<?php $i = 0; ?>
		<?php foreach ($model as $data){ ?>
			<?php ++$i; ?>
			<?php
				//Проверяю существование файла
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
				<a href="/catalog/<?=$data->id;?>" class="items-block-item-img">
					<table>
						<tr><td></td></tr>
						<tr><td><img src="<?=$url_img_small?>" alt=""></td></tr>
						<tr><td></td></tr>
					</table>
				</a>
				<a class="items-block-item-name" href="/catalog/<?=$data->id;?>"><?=$data->name;?></a>

				<div class="buy-btn buy-btn-product" style="padding-left: 17px;"></div>
				<div class="item-count-area">
					<a href="" class="item-count-inc"></a>
					<input value="1" class="item-count product_<?=$data->id;?>_count" type="text">
					<a href="" class="item-count-dec"></a>
				</div>
				<div class="items-block-item-price"><?=$data->price;?> руб.</div>
				<div class="order_one_click">
					<a href="javascript:void(0)"
					   class="fastorder"
					   idx="<?=$data->id;?>"
					   names="<?=$data->name;?>"
					   pic="<?=$url_img?>"
					>
						Заказать
					</a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script>
$(function() {
  $('.dropdown-toggle').dropdown();
});

</script>



<?=$filters?>



  <div class="pagination">
    <?$this->widget('CLinkPager', array('pages' => $pages));?>
  </div>



<script>
$(function() {
	$('.parent_lmcontainer_'+<?=$modelRubric->id?>).show();
	$('.parent_lmcontainer_'+<?=$modelRubric->parent_id?>).show();
	$('.lmenu_item_<?=$modelRubric->id?> > a').css('background-color','#e5e5e5');
});
</script>
