<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<h1 class="lined nopaddingtop" style="margin-top: 10px;">Каталог продукции</h1>
<?
$this->pageTitle ='Каталог продукции - '.$_SERVER['HTTP_HOST'];
?>







<div class="tovar_container">
<?php foreach ($model_elements as $data){ 
$element = CatalogElements::model()->getProduct($data->id);
if (isset($element['url']))
{
	$url = Yii::app()->request->requestUri.$element['url'].(SiteModuleSettings::getUrl($data,4));
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
				<tr><td class="rollover"><img src="<?=$url_img?>" alt=""></td></tr>
				<tr><td></td></tr>
			</table>
		</a>
		<a class="items-block-item-name" href="<?=$url;?>"><?=$data->name;?></a>
		<div class="item-price-count">
			<div class="items-block-item-price"><?=$data->price;?> руб.</div>
			<div class="item-count-area">
				<a href="" class="item-count-inc"></a>
				<input value="1" class="item-count" type="text">
				<a href="" class="item-count-dec"></a>
			</div>
		</div>
		<div class="clearOnly">&nbsp;</div>
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
	
	
<div class="panel panel-default paginator-panel">
  <div class="panel-body">
    <?$this->widget('CLinkPager', array('pages' => $pages));?>
  </div>
</div>



<?=$filters?>
