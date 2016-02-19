<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.min.css" />
    <link rel="stylesheet" href="/css/bootstrap-select.min.css"/>
	<link rel="stylesheet" href="/css/styles_old.css"/>
	<link href="/css/jquery.bxslider.css" rel="stylesheet" />
	
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
	<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
	
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>    
    <script src="/js/jquery.bxslider.min.js"></script>

    <script src="/js/script.js"></script>
    <script src="/js/main.js"></script>
    <link rel="stylesheet" href="/public/themes/wengerland/components/lightbox2-master/dist/css/lightbox.min.css"/>
	<link rel="stylesheet" href="/css/Fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="/js/jquery.jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script>
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1">
    <base href="http://<?=$_SERVER['HTTP_HOST']?>/">
	
    <script type="text/javascript">
	$(document).ready(function() {
		$("a.group").fancybox({
			'speedIn':	300,
			'speedOut':	300,
			'overlayColor':	'#000',
			'overlayOpacity':	0.7
		});
	});
	</script>
	<link rel="stylesheet" href="/css/styles.css"/>
</head>
<body id="f1a">
	<div id="pageWrap">
		<div id="innerPageWrap">
			<div id="header">
				<h3 id="masthead" style="width:259px;height:187px;background: url(/images/masthead_title.png) no-repeat;"><a href="./">Меховое ателье Зацепина</a></h3><p class="outOfSight"><a href="#begin-content">Skip navigation and go to main content</a></p>
				<?=$this->widget('application.apps.frontend.components.TopMenu',array(), TRUE)?>
			</div>

			<div id="outerContentWrap">
				<!-- begin #feature  -->
				<div id="feature" class="bleed">
					<!--TYPO3SEARCH_begin-->
					<div id="c15" class="csc-default">
						<?php 
							$request = Yii::app()->request->requestUri;
							$arr = explode("/",$request);
							if ($arr[0])
								$url = $arr[0];
							else
								$url = $arr[1];
						?>
						<? $page = Pages::model()->find("url='".$url."'");?>
						<?if ($page && $page->image) :?>
							<img class="plainImage" src="/uploads/filestorage/menu/elements/<?= $page->id; ?>.<?= $page->image; ?>" alt="" width="950" height="339" border="0" />
						<?else:?>
							<img class="plainImage" src="/images/woman-top.jpg" alt="" width="950" height="339" border="0" />
						<?endif;?>
					</div>
					<!--TYPO3SEARCH_end-->
					<div class="clearOnly"> </div>
				</div>
				<!-- end #feature  -->
				<div id="contentWrap">
					<?php  echo $content; ?>
					<div class="clearOnly"> </div>
				</div>
				<!-- end #contentWrap  -->
			</div>
			<!-- begin #footerWrap  -->	
			
			<div id="footerWrap">
				<div id="footer" class="clear"><div id="footer_phone"><div id="c61" class="csc-default" >
				
					<span style="font-size: 60%; vertical-align: top;">+7 495</span> 543 5839

				</div></div><div id="footer_accept_cards"><div id="c62" class="csc-default" ><div class="csc-textpic csc-textpic-intext-right-nowrap"><div class="csc-textpic-imagewrap">
			   
					<ul><li class="csc-textpic-image csc-textpic-firstcol" style="width:38px;"><img src="/images/visa.png" width="38" height="33" border="0" alt="" /></li><li class="csc-textpic-image" style="width:39px;"><img src="/images/mastercard.png" width="39" height="33" border="0" alt="" /></li><li class="csc-textpic-image" style="width:40px;"><img src="/images/dinners.png" width="40" height="33" border="0" alt="" /></li><li class="csc-textpic-image csc-textpic-lastcol" style="width:26px;"><img src="/images/jcb.png" width="26" height="33" border="0" alt="" /></li></ul>

			   </div><div style="margin-right:183px;"><div class="csc-textpic-text"><div class="csc-textpicHeader csc-textpicHeader-25">
				
					<h5 class="csc-firstHeader">Мы принимаем:</h5>

				</div><p><strong><br /></strong></p></div></div></div><div class="csc-textpic-clear"><!-- --></div></div></div>
				
				<?=$this->widget('application.apps.frontend.components.BottomMenu',array(), TRUE)?>
				<div id="footer_address"><div id="c63" class="csc-default" >	
				
				<p>Москва, Ленинградский пр-т, 37-Б<br />Торговый центр "СТАРТ", 3-й этаж, павильон №65-Б</p>

				<p>E-mail: <a href="mailto:info@otido-shyba.ru" >info@otido-shyba.ru</a></p></div></div>

				<div id="footer_counter">
				</div>

				<div class="clearOnly">&nbsp;</div></div><!-- end #footer  -->
			</div>
			<!-- end #footerWrap  -->
		</div>
	</div>
	
	<div id="shadowbox_container" style="display:none;">
		<div id="shadowbox"></div>
		<div id="modalbox">
			<div style="padding-top:5px; padding-bottom:5px;">Товар добавлен в корзину.</div>
			<a href="javascript:void(0)" onclick="$('#shadowbox_container').hide();">Продолжить покупки</a>
			<a href="/basket" style="margin-left: 20px;">Перейти в корзину</a>
			<script>
				$(function() {
					$('#shadowbox').css({'height':($('body').height())+'px'});
					$('#modalbox').css({'margin-left':(Number($('body').width())/2-200)+'px'});
				});
			</script>
		</div>
	</div>
	<!--script src="/public/themes/wengerland/components/lightbox2-master/dist/js/lightbox.min.js"></script-->

	<div class="modal fade" tabindex="-1" role="dialog" id="modal_fastorder">
	  <div class="modal-dialog">
		<div class="modal-content" style="padding: 10px;">
		  <div class="modal-header" style="padding: 0px; padding-bottom: 5px;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h1 class="modal-title" style="text-align:center;">Заказать в один клик</h1>
		  </div>
		  <div class="modal-body" style="padding: 5px;">

	<div style="color:#a40000; font-weight:bold; padding:5px; text-align:center; font-size:14px;" id="fo_error_msg"></div>

	<div style="color:#4e9a06; font-weight:bold; padding:5px; text-align:center; font-size:14px;" id="fo_confirm_msg"></div>

	<div style="display: table; width: 100%;">
		<div class="col-md-6" style="padding: 0px;">
			<div style="font-weight: bold; font-size: 16px; padding-bottom: 5px; text-align: center;" id="fo_product_title"><h1>Название товара</h1></div>
			<div style="display: table;text-align: center; width: 100%;">
				<div class="col-md-12">
					<img src="" style="max-width: 300px;" id="fo_product_pic">
				</div>

			</div>
		</div>
		<div class="col-md-6">
			<form method="post" id="form_fastorder">
				<input type="hidden" id="fo_id_product">
				<div class="form-group">
				  <label>Имя</label>
				  <input type="text" class="form-control" id="fo_name" placeholder="Введите имя">
				</div>
				<div class="form-group">
				  <label>Email</label>
				  <input type="email" class="form-control" id="fo_email" placeholder="Введите ваш email">
				</div>
				<div class="form-group">
				  <label>Телефон</label>
				  <input type="text" class="form-control" id="fo_phone" placeholder="Введите контактный телефон">
				</div>
			</form>
			<div class="product_message">
				<b>ЕСЛИ У ВАС ОСТАЛИСЬ ВОПРОСЫ, ПОЗВОНИТЕ НАМ +7 (495) 543-58-39</b>
				<p>* Цена на сайте указана ориентировочная, окончательная стоимость зависит от цвета соболя, будет ли изделие вдоль или поперек, какое количество замши стоит между шкурами, наличие капюшона, расклешенности, наличие пояса.
					</p>
			</div>
		</div>
		
	</div>



		  </div>
		  <div class="modal-footer" style="padding: 10px 0px 0px;">
			  <div class="col-md-6">
				  <div class="items-block-item-price items-block-item-price_first">Цена: <span id="fo_item_price"></span> руб.</div>
				  <div class="items-block-item-price">Старая цена: <span class="old_price_f"><span id="fo_item_old_price"></span> руб.</span></div>


			  </div>
			  <div class="col-md-5 fastorder_btns">
				  <button type="button" class="fastorder_order likebuybtn" id="fo_submit">Заказать</button>
				  <button type="button" class="fastorder_close" data-dismiss="modal">Закрыть</button>
			  </div>


		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</body>
</html>
