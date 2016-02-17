<div id="filters_container_inner">
<div class="left-menu">
  <div class="left-menu-header">
      Фильтр товаров
  </div>

<FORM METHOD="POST">
</FORM>

  <div class="left-menu-content">
		<div>

			<FORM METHOD="POST">
			
<?

foreach ($filters_actual as $filters_actual_item)
{
	$values = array();
	foreach ($chars_actual as $chars_actual_item)
	{
		if ($filters_actual_item['charsname']==$chars_actual_item['name'])
		{
			if ($chars_actual_item['type_scale']==1)
			{
				$values[] = trim($chars_actual_item['scale']);
			}
			elseif($chars_actual_item['type_scale']==2)
			{
				$scalearr = explode('|',$chars_actual_item['scale']);
				foreach ($scalearr as $scalearr_item)
				{
					if (strlen(trim($scalearr_item)))
					{
						$values[] = trim($scalearr_item);
					}
				}
			}
		}
	}




	$values = array_unique($values);
	$values_int = array();
	foreach ($values as $values_item)
	{
		if (intval($values_item))
		{
			$values_int[] =intval($values_item);
		}
	}



	$id_filter = $filters_actual_item['id'];
	if (count($values))
	{
		if ($filters_actual_item['type']==0)
		{
			echo '<div class="form-group">
				      <div><label>'.$filters_actual_item['name'].'</label></div>';
			foreach ($values as $values_item)
			{
				$checked="";
				if (
				    (isset($filters[$id_filter][$filters_actual_item['charsname']]['checkbox']))&&
				    (in_array($values_item,$filters[$id_filter][$filters_actual_item['charsname']]['checkbox']))
				   )
				{	
					$checked='checked="checked"';
				}
?>
				<div class="checkbox">
					<label>
					  <input type="checkbox" 
					         name="filter[filter_<?=$id_filter?>][checkbox][]" <?=$checked?> value="<?=$values_item?>"><?=$values_item?>
					</label>
				</div>
<?
			}
			echo '</div>';
		}
		elseif(($filters_actual_item['type']==1)&&(count($values_int)>1))
		{

			$min = min($values_int);
			$max = max($values_int);
			$cur_min = $min;
			$cur_max = $max;
			
			if (
			    (isset($filters[$id_filter][$filters_actual_item['charsname']]['scroll']))
			   )
			{	
				$cur_min = intval($filters[$id_filter][$filters_actual_item['charsname']]['scroll']['min']);
				$cur_max = intval($filters[$id_filter][$filters_actual_item['charsname']]['scroll']['max']);
			}
			
			//if (isset())
			$nofilter = false;
			if (isset($filters[$id_filter][$filters_actual_item['charsname']]['scroll']['nofilter']))
			{
				$nofilter = true;
			}
			if (!isset($filters))
			{
				$nofilter = true;
			}
			$nofilter_checked = "";
			if ($nofilter)
			{
				$nofilter_checked = 'checked="checked"';
			}
			$id_filter = $filters_actual_item['id'];
			
			
			
			
			$usefilter = false;
			if (isset($filters[$id_filter][$filters_actual_item['charsname']]['scroll']['usefilter']))
			{
				$usefilter = true;
			}
			$usefilter_checked = "";
			if ($usefilter)
			{
				$usefilter_checked = 'checked="checked"';
			}
?>

 <script>
  $(function() {
    $( "#filter-range-<?=$id_filter?>" ).slider({
      range: true,
      min: <?=$min?>,
      max: <?=$max?>,
      values: [ <?=$cur_min?>, <?=$cur_max?> ],
      slide: function( event, ui ) {
        $( "#filter_<?=$id_filter?>_text" ).val( ui.values[ 0 ]+"" + " - " + ui.values[ 1 ]+"" );
        
        $("#filter_<?=$id_filter?>_min").val(ui.values[0]);
        $("#filter_<?=$id_filter?>_max").val(ui.values[1]);
      }
    });
    $( "#filter_<?=$id_filter?>_text" ).val( $( "#filter-range-<?=$id_filter?>" ).slider( "values", 0 )+"" +
      " - " + $( "#filter-range-<?=$id_filter?>" ).slider( "values", 1 )+"" );
    $("#filter_<?=$id_filter?>_min").val($("#filter-range-<?=$id_filter?>").slider("values",0));
    $("#filter_<?=$id_filter?>_max").val($("#filter-range-<?=$id_filter?>").slider("values",1));
  });
  </script>
  
	<div class="form-group">
		<label><?=$filters_actual_item['name']?></label>
		<p>
			<input type="text" id="filter_<?=$id_filter?>_text" readonly 
			       style="border:0; color:#AB1129; font-weight:bold;">
			<input type="hidden" name="filter[filter_<?=$id_filter?>][scroll][min]" id="filter_<?=$id_filter?>_min">
			<input type="hidden" name="filter[filter_<?=$id_filter?>][scroll][max]" id="filter_<?=$id_filter?>_max">
		</p>
		<div id="filter-range-<?=$id_filter?>"></div>
		<div class="checkbox">
		  <label>
		    <input type="checkbox" 
		           name="filter[filter_<?=$id_filter?>][scroll][nofilter]" 
		           <?=$nofilter_checked?>
		           value="1">Показывать без свойства
		  </label>
		</div>
		<div class="checkbox">
		  <label>
		    <input type="checkbox" 
		           name="filter[filter_<?=$id_filter?>][scroll][usefilter]" 
		           <?=$usefilter_checked?>
		           value="1">Использовать фильтр
		  </label>
		</div>
	</div>

<?
		}
	}
}







$price_cur_min = $price_min;
$price_cur_max = $price_max;
if (
     (isset($filters['price_min']))&&
     ($filters['price_min']>=$price_min)&&
     ($filters['price_min']<=$price_max)
   )
{
	$price_cur_min = $filters['price_min'];
}

if (
     (isset($_filters['price_max']))&&
     ($filters['price_max']>=$price_min)&&
     ($filters['price_max']<=$price_max)
   )
{
	$price_cur_max = $filters['price_max'];
}

?>
 <script>
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: <?=$price_min?>,
      max: <?=$price_max?>,
      values: [ <?=$price_cur_min?>, <?=$price_cur_max?> ],
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ]+"руб." + " - " + ui.values[ 1 ]+"руб." );
        $( "#amount" ).val( ui.values[ 0 ]+"руб." + " - " + ui.values[ 1 ]+"руб." );
        
        $("#filter_price_min").val(ui.values[0]);
        $("#filter_price_max").val(ui.values[1]);
      }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 )+"руб." +
      " - " + $( "#slider-range" ).slider( "values", 1 )+"руб." );
    $("#filter_price_min").val($("#slider-range").slider("values",0));
    $("#filter_price_max").val($("#slider-range").slider("values",1));
  });
  </script>
  
	<div class="form-group">
		<label>Цена</label>
		<p>
			<input type="text" id="amount" readonly style="border:0; color:#AB1129; font-weight:bold;">
			<input type="hidden" name="filter[price_min]" id="filter_price_min">
			<input type="hidden" name="filter[price_max]" id="filter_price_max">
		</p>
		<div id="slider-range"></div>
	</div>


  <button type="submit" class="btn btn-danger btn_search btn-lg">Подобрать</button>
  </FORM>
  
  
  
  
  
  
  <div class="reset_params">
	  <form method="post" id="reset_filter_form">
	  	<input type="hidden" value="1" name="reset_filter_form">
  		<a href="javascript:void(0)" onclick="$('#reset_filter_form').submit()">Сбросить параметры</a>
  	</form>
  </div>



		</div>
  </div>
</div>
</div>
<script>
$(function() {
	var html = $('#filters_container_inner').html();
	$('#filters_container').html(html);
	$('#filters_container_inner').html('');
	//alert(1);
});
</script>
<?  






?>
