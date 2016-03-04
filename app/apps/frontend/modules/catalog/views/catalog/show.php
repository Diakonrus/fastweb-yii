<!-- Товар -->
<div class="catalog-item-detail catalog-item-detail2">
	<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>
	<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>

	<div class="clear"></div>
    <div class="row item-detail-parts">
		<?php
			//Проверяю существование файла
			$url_img_small = '/images/nophoto_100_100.jpg';
			$url_img_medium = $url_img_small;
			$url_img_small = $url_img_small;
			$url_img = $url_img_small;
			$filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image;
			if (file_exists($filename)){ $url_img = '/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image; }
			if (file_exists($filename)){ $url_img_small = '/uploads/filestorage/catalog/elements/small-'.$model->id.'.'.$model->image; }
			if (file_exists($filename)){ $url_img_medium = '/uploads/filestorage/catalog/elements/large-'.$model->id.'.'.$model->image; }

		?>

		

		<div class="item-page-img-additional thumb_pager">
			<ul class="th_slide">
				<li class="active">
					<a class="fancy_slide" href="<?=$url_img?>" data-slide-index="0" data-lightbox="example-1" rel="gallery-2">
						<img src="<?=$url_img_small?>"  alt=""/>
            		</a>
            	</li>

				<!-- Дополнительные картинки -->
				<?php foreach ($modelImages as $data) { ?>
					<?php
						$filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/'.$data->image_name.'.'.$data->image;
						if (file_exists($filename)){ $url_imgs = '/uploads/filestorage/catalog/elements/'.$data->image_name.'.'.$data->image; }
						if (file_exists($filename)){ $url_imgs_small = '/uploads/filestorage/catalog/elements/small-'.$data->image_name.'.'.$data->image; }
						if (file_exists($filename)){ $url_imgs_medium = '/uploads/filestorage/catalog/elements/large-'.$data->image_name.'.'.$data->image; }
					?>

					<li>
						<a class="fancy_slide" href="<?=$url_imgs?>" data-slide-index="1"  data-lightbox="example-1" rel="gallery-2">
							<img src="<?=$url_imgs_small?>" alt=""/>
						</a>
					</li>

				<?php } ?>

				<?php if(!empty($model->code_3d)): ?>
				<li>
					<a href="<?php echo Yii::app()->urlManager->createUrl('/catalog/catalog/getcodethreed', array('id' => $model->id)); ?>" class="act-get-code-3d">
						<img src="/images/3ds.png"  alt=""/>
					</a>
				</li>
				<?php endif; ?>
			</ul>




			
		</div>
		<div class="item-page-img thumb_slider">
			<div class="img_slide">
				<a class="example-image-link group product_big_img" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
					<?php if ($model->shares==1){ ?>
						<div class="shares">

						</div>
					<?php } ?>
					<img src="<?=$url_img_medium?>" class="product_cart_big_img"  alt=""/>
				</a>
			</div>
			<div class="code-3d">

			</div>
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
					<div class="product_price <?php if ($model->price_old > 0){ ?>product_old_price_active<?php } ?>">
	            		<?=$model->price;?> руб
	           	 	</div>
					<?php if ($model->price_old > 0){ ?>
	           	 	<div class="product_old_price">
						<?=$model->price_old;?> руб.
	           	 	</div>
					<?php } ?>
				</div>
	            

	            <div class="">
					<a href="javascript:void(0)" 
						 class="fastorder fastorder_product"
						 idx="<?=$model->id;?>"
						 names="<?=$model->name;?>"
						 pic="<?=$url_img?>"
						 price="<?=$model->price?>"
					     old_price="<?=$model->price_old;?>"
					     sales="<?php if ($model->shares==1){ ?>1<?php } ?>"
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
    

<script>
	$(document).ready(function() {
		$('.act-get-code-3d').click(function() {
			$.ajax({
				url: $(this).attr('href'),
				type: "GET",
				dataType: "JSON",
				success: function(data) {
					$('.code-3d').html(data);
				}
			});
			return false;
		});
	});
</script>

