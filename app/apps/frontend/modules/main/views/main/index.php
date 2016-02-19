<?
$this->pageTitle = 'Интернет магазин перочинных ножей, купить перочинные ножи с доставкой - '.$_SERVER['HTTP_HOST'];
Yii::app()->clientScript->registerMetaTag('В интернет магазине '.$_SERVER['HTTP_HOST'].' вы сможете купить перочинные ножи по выгодной цене с доставкой.', 'description');
?>


										<div class="sliderblock logos" style="">
										
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
<?

$photos = PhotoElements::model()->findAll('parent_id=2 AND status = 1');
$i=0;
foreach ($photos as $photos_item)
{
	$filename = '/uploads/filestorage/photo/elements/'.$photos_item->id.'.'.$photos_item->image;

	$slide='
	<div class="item '.((!$i)?'active':'').'">
		  <img src="'.$filename.'" alt="">
		  <div class="carousel-caption">
		      <h3>'.$photos_item->name.'</h3>
		      <p>'.$photos_item->url.'</p>
		  </div>
	</div>
	';
	echo $slide;
	$i++;
}

?>
                
                    </div>

                    <!-- Controls -->
                    <div class="carousel-controls">
                        <a href="" class="carousel-prev"></a>
                        <a href="" class="carousel-next"></a>
                    </div>
                </div>
                
										</div>



<!--
                    <div class="items-block-bestsallers">
                        <h1 class="lined">Популярные</h1>
                        <div class="tovar_container">


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/2.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/3.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>




	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>




	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>


	<div class="items-block-item">
		<div class="item-label bestsaller">хит</div>
		<a href="" class="items-block-item-img"><img src="images/product/1.png" alt=""></a>
		<a class="items-block-item-name" href="">Нож Evolution S101. 8 инструментов. С двумя клинками.</a>
		<div class="items-block-item-price">171.00 руб.</div>
		<a class="buy-btn" href="">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="">Заказать в 1 клик</a>
		</div>
	</div>




                        </div>
                    </div>
-->
                    <div class="items-block-new">
                        <h1 class="lined">Новинки рынка</h1>
                        <div class="tovar_container">



<?


$model_CatalogElements = CatalogElements::model()->findAll('status = 1 ORDER BY order_id LIMIT 0,12');

foreach ($model_CatalogElements as $element_item)
{

$element = CatalogElements::model()->getProduct($element_item->id);
if (isset($element['url']))
{
	$url = '/catalog'.$element['url'].'/'.$element_item->id;
}

	$modelRubric =  CatalogRubrics::model()->find('id='.$element_item->parent_id);
	$filename = '/uploads/filestorage/catalog/elements/'.$element_item->id.'.'.$element_item->image;
$name_noqoutes = $element_item->name;
$name_noqoutes = str_replace("'",'',$name_noqoutes);
$name_noqoutes = str_replace('"','',$name_noqoutes);
$name_noqoutes = htmlspecialchars($name_noqoutes,ENT_QUOTES);
$name_noqoutes = str_replace('&#039;','',$name_noqoutes);

?>
	<div class="items-block-item">
		<div class="item-label new-product">new</div>
		<a href="<?=$url?>" class="items-block-item-img">
			<table>
				<tr><td></td></tr>
				<tr><td><img src="<?=$filename?>" alt=""></td></tr>
				<tr><td></td></tr>
			</table>
		</a>
		<a class="items-block-item-name" href="/catalog/<?=$modelRubric->url?>/<?=$element_item->id?>"><?=$element_item->name?></a>
		<div class="items-block-item-price"><?=$element_item->price?> руб.</div>
		<a class="buy-btn" href="javascript:void(0);" onclick="javascript:return SupposeInBasket('catalog/<?=$element_item->id;?>', 'catalog', 'price','<?=$element_item->id;?>','<?=$name_noqoutes;?>',0,1,'','','','1')">В корзину</a>
		<div class="item-count-area">
			<a href="" class="item-count-inc"></a>
			<input value="1" class="item-count" type="text">
			<a href="" class="item-count-dec"></a>
		</div>
		<div class="order_one_click">
			<a href="javascript:void(0)" class="fastorder" idx="<?=$element_item->id;?>">Заказать в 1 клик</a>
		</div>
	</div>

<?
}
?>




                        </div>
                    </div>
                    <div class="promo-text">
                        <h1>Заголовок sео-текста</h1>
                        <p>
Безупречное качество, максимальная функциональность, абсолютная надежность. Достаточно купить швейцарский нож Wenger для того, чтобы ощутить каждое из этих преимуществ. Наша продукция создается для того, чтобы вы могли чувствовать себя уверенно, путешествуя по бескрайним просторам планеты, покоряя водную стихию, горы, прокладывая маршруты по бесконечным лесам. Перочинные швейцарские складные ножи созданы для тех, кто стремится к свободе, уверенности, не желает идти на поводу у обстоятельств. Несмотря на то, что после выпуска первой модели прошло более 115-ти лет, они также популярны у охотников, альпинистов, рыбаков и просто людей, предпочитающих активный отдых. За это время швейцарский складной нож завоевал безупречную репутацию и стал привычной вещью в рюкзаке любого путешественника. 
                        </p>
                    </div>
                
