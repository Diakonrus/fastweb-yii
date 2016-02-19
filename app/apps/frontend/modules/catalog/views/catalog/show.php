<!-- Товар -->
<div class="catalog-item-detail catalog-item-detail2">
	<ul class="crosh">
		<li>
			<a href="">Главная</a>
		</li>
		<li>></li>
		<li>
			<a href="">Шубы и меха</a>
		</li>
		<li>></li>
		<li>
			<a href="">Шуба из норки</a>
		</li>
	</ul>
	<div class="clear"></div>
    <div class="row item-detail-parts">
		<?php
			//Проверяю существование файла
			$url_img = '/images/nophoto_100_100.jpg';
			$filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image;
			if (file_exists($filename)){ $url_img = '/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image; }
			if (file_exists($filename)){ $url_img_small = '/uploads/filestorage/catalog/elements/small-'.$model->id.'.'.$model->image; }
			if (file_exists($filename)){ $url_img_medium = '/uploads/filestorage/catalog/elements/medium2-'.$model->id.'.'.$model->image; }

		?>

		

		<div class="item-page-img-additional">
			<ul class="bxslider">
				<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
						<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
            		</a>
            	</li>	

            	<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
	            	</a>
				</li>

				<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
	            	</a>
				</li>

				<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
	            	</a>
				</li>

				<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
	            	</a>
				</li>

				<li>
					<a class="example-image-link-additional group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_img_small?>" style="max-width: 300px;" alt=""/>
	            	</a>
				</li>
				
			</ul>
			
			
		</div>
		<div class="item-page-img">
            <a class="example-image-link group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
				<img src="<?=$url_img_medium?>" style="max-width: 300px;" alt=""/>
            </a>
        </div>		
        <div class="item-page-params">
            <div class="item-detail-text" style="display:none;">
            <? //print_r($model)?>
						<?=$model->brieftext;?>
            </div>
            <div class="params-price">
				<h1>
					<?=$model->name;?>
				</h1>

				<?if ($model->code):?>
					<div class="code_product">Код товара: <?=$model->code;?></div>
					
				<?endif; ?>
				
				<div class="product_price_block">
					<div class="product_price">
	            		<?=$model->price;?> руб
	           	 	</div>
	           	 	<div class="product_old_price">
	           	 		249 990 руб.
	           	 	</div>
				</div>
	            

	            <div class="">
					<a href="javascript:void(0)" 
						 class="fastorder fastorder_product"
						 idx="<?=$model->id;?>"
						 names="<?=$model->name;?>"
						 pic="<?=$url_img?>"
						 price="<?=$model->price?>"
					     old_price="199990"
						 >
						Заказать
					</a>
				</div>

				
				<div>
					<?
						$characteristics = array();
						foreach ($modelChars as $item)
						{
							if (($item->type_parent==2)&&(strlen($item->scale)))
							{
								//echo $item->name.' = '.$item->scale.'<br>';
								$scale = $item->scale;
								if (strpos($scale,'|')!==false)
								{
									$scale_arr = explode('|',$scale);
									$scale = array();
									foreach ($scale_arr as $scale_arr_item)
									{
										if (strlen($scale_arr_item))
										{
											if ($item->type_scale==3)
											{
												$scale[]='<span class="label label-default" style=" padding-left: 10px; background:'.$scale_arr_item.'">&nbsp;</span>';
											}
											else
											{
												$scale[]=$scale_arr_item;
											}
											
										}
									}
								}
								$characteristics[$item->name]=$scale;
							}
							
						}
						?>
						<?if (count($characteristics)):?>
							<div class="product_param">
								<div class="product_param_name">Детали</div>	
														
								<table>
							    <?foreach ($characteristics as $key => $value){?>
											<tr>
												<td class="table_key"><?=$key?>:</td>
												<td><?
												if (is_array($value))
												{
													echo implode(' - ',$value);
												}
												else
												{
													echo $value;
												}
												
												?></td>
											</tr>
							    <?}?>
							    </table>
							</div>    
						<?endif;?>
				</div>
				
			</div>	
			<div class="clear"></div>

			<div class="line_after product_social">
				<div class="block_name">
					Поделиться
				</div>
				<div class="item">
					<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
					<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
					<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter" data-size="s"></div>
				</div>	
				<div class="clear"></div>			
			</div>
			<div class="product_message">
				<b>ЕСЛИ У ВАС ОСТАЛИСЬ ВОПРОСЫ, ПОЗВОНИТЕ НАМ +7 (495) 543-58-39</b>				
				<p>* Цена на сайте указана ориентировочная, окончательная стоимость зависит от цвета соболя, будет ли изделие вдоль или поперек, какое количество замши стоит между шкурами, наличие капюшона, расклешенности, наличие пояса.
				</p>
			</div>			
        </div>
    </div>

   
</div><!--page-content end-->


 <div class="product_content">
    	<div class="block_name">
    		<h3>
        		ОПИСАНИЕ
    		</h3>
    	</div>
    	    	
    	 <div class="item-detail-description slide-items">
			<?=$model->description;?>
    	</div>
    </div>
    



