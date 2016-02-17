<?
$this->pageTitle = 'Купить '.$model->name.' - '.$_SERVER['HTTP_HOST'];
Yii::app()->clientScript->registerMetaTag($model->name.' купить в интернет магазине '.$_SERVER['HTTP_HOST'].' по выгодной цене с доставкой.', 'description');
?>
<!-- Товар -->
<div class="catalog-item-detail">
    <h1>
        <?=$model->name;?>
    </h1>
    <div class="row item-detail-parts">
        <div class="item-page-img">
            <?php
                //Проверяю существование файла
                $url_img = '/images/nophoto_100_100.jpg';
                $filename = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image;
                if (file_exists($filename)){ $url_img = '/uploads/filestorage/catalog/elements/'.$model->id.'.'.$model->image; }
                if (file_exists($filename)){ $url_img_small = '/uploads/filestorage/catalog/elements/medium-'.$model->id.'.'.$model->image; }
            ?>
            <a class="example-image-link group" href="<?=$url_img?>" data-lightbox="example-1" rel="gallery-2">
				<img src="<?=$url_img_small?>" style="max-width: 230px; max-height: 300px;" alt=""/>
            </a>
        </div>
        <div class="item-page-params">
            <div class="item-detail-text" style="display:none;">
            <? //print_r($model)?>
						<?=$model->brieftext;?>
            </div>
            <div class="params-price">
	            <div class="row" style="margin-bottom: 20px;">
	            		<div class="col-xs-12">
	                    <div class="item-detail-prop-header">Цена:</div>
	                    <span class="item-detail-price price-product-detail"><?=$model->price;?> руб</span>
	            		</div>
	            </div>
				<?if ($model->code):?>
					<div class="row">
						<div class="col-xs-12">
							<div class="item-detail-prop-header">Модель:</div>
							<?=$model->code;?>
						</div>
					</div>
				<?endif; ?>
				<div class="order_one_click">
					<a href="javascript:void(0)" 
						 class="fastorder"
						 idx="<?=$model->id;?>"
						 names="<?=$model->name;?>"
						 pic="<?=$url_img?>"
						 >
						Заказать
					</a>
				</div>
			</div>	          
        </div>
    </div>
    <h2>
        ОПИСАНИЕ
    </h2>
    <?=$model->description;?>
    


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
        <a href="" class="item-detail-props-toggle slide-trigger">Характеристики</a>
        <div class="item-detail-props slide-item">
        		<table class="table table-striped table-bordered table-hover">
           <?foreach ($characteristics as $key => $value){?>
						<tr>
							<td><?=$key?></td>
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
</div><!--page-content end-->




