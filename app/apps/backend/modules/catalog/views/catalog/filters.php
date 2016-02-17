<?
function fn__get_multiselect_opts($categs_array,$parent_id,$level,$categs_array_selected)
{
	$ret='';
	foreach ($categs_array as $key => $value)
	{
		if ($value['parent_id']==$parent_id)
		{
			$selected='';
			if (isset($categs_array_selected[$key]))
			{
				$selected=' selected="selected" ';
			}
			$ret.= '<option value="'.$key.'" style="padding-left:'.(20*$level).'px;" '.$selected.'>'.
			        $value['name'].'</option>';
			if ($key)
			{
				$ret.=fn__get_multiselect_opts($categs_array,$key,$level+1,$categs_array_selected);
			}
			//
		}
	}
	return $ret;
}




function fn__get_checkbox_opts($categs_array,$parent_id,$level,$categs_array_selected)
{
	$ret='';
	foreach ($categs_array as $key => $value)
	{
		if ($value['parent_id']==$parent_id)
		{
			$selected='';
			if (isset($categs_array_selected[$key]))
			{
				$selected=' checked="checked" ';
			}
			$ret.= '
			<div>
				<input type="checkbox"  value="'.$key.'" 
				       name="CatalogFIltersInCategory[id_catalog_rubrics][]"
				       '.$selected.'>
			  <span style="padding-left:'.(20*$level).'px;">'.$value['name'].'</span>
			</div>';
			if ($key)
			{
				$ret.=fn__get_checkbox_opts($categs_array,$key,$level+1,$categs_array_selected);
			}
			//
		}
	}
	return $ret;
}



if ((!isset($categs_array_selected)) || (!is_array($categs_array_selected)))
{
	$categs_array_selected = array();
}


?>

<script>
function confirmDelete() {
	if (confirm("Вы подтверждаете удаление?")) {
		return true;
	} else {
		return false;
	}
}
</script>
<?
$type_array = array('0'=>'Checkbox','1'=>'Scroll',2=>'Select');
?>

<?if ($action=='list'):?>


	<?
		$categs_array_selected = array();
		if (isset($_GET['catid']))
		{
			$_GET['catid'] = intval($_GET['catid']);
			$categs_array_selected = array($_GET['catid']=>1);
		}
		

	?>

	<div>
		<select style="width:100%;" 
				    id="selector_catid">
		<?
			echo fn__get_multiselect_opts($categs_array,0,0,$categs_array_selected);
		?>
		</select>
	</div>
                               
                               
                               
<script>
$( "#selector_catid" ).change(function() {
	window.location.href = '/admin/catalog/catalog/filters?catid='+$(this).val();
});
</script>

	<table class="table table-striped table-bordered table-hover"  cellspacing="0">
		<thead>
			<tr>
				<th style="text-align:center; width:21px">
					#
				</th>
				<th>Название фильтра</th>
				<th>Название характеристики</th>
				<th width="10" nowrap="" style="width: 120px;">Тип</th>
				<th width="10" nowrap="" style="width: 90px;">Статус</th>
				<th width="10" nowrap="" style="width: 90px;">Позиция</th>
				<th nowrap="" colspan="4" style="width: 70px;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($model_filters as $model_filters_item)
				{
					$type_name = $type_array[$model_filters_item->type];
					$catid_txt='';
					if ((isset($_GET['catid']))&&(intval($_GET['catid'])))
					{
						$catid_txt = '&catid='.intval($_GET['catid']);
					}
				?>
					<tr>
						<td class="n1">
							<?=$model_filters_item->id?>
						</td>
						<td><?=$model_filters_item->name?></td>
						<td><?=$model_filters_item->charsname?></td>
						<td><?=$type_name?></td>
						<td style="text-align:center;"><?=(($model_filters_item->status)?'Вкл':'Выкл')?></td>
						<td style="text-align:center;"><?=$model_filters_item->position?></td>
						<td style="width: 70px; text-align:center;">
							<a href="/admin/catalog/catalog/filters?action=chpos&do=inc&id=<?=$model_filters_item->id?><?=$catid_txt?>" 
								 data-toggle="tooltip" 
								 data-original-title="Переместить вверх">
								<i class="icon-arrow-up"></i>
							</a>
							<a href="/admin/catalog/catalog/filters?action=chpos&do=dec&id=<?=$model_filters_item->id?><?=$catid_txt?>" 
								 data-toggle="tooltip" 
								 data-original-title="Переместить вниз">
								<i class="icon-arrow-down"></i>
							</a>
							
							<a href="/admin/catalog/catalog/filters?action=update&id=<?=$model_filters_item->id?><?=$catid_txt?>" 
								 data-toggle="tooltip" 
								 title="" 
								 data-original-title="Редактировать фильтр">
								<i class="icon-pencil"></i>
							</a>
							<a href="/admin/catalog/catalog/filters?action=delete&id=<?=$model_filters_item->id?>" 
								 data-toggle="tooltip" 
								 title="" 
								 onclick="return confirmDelete();"
								 data-original-title="Удалить фильтр">
								<i class="icon-trash"></i>
							</a>
						</td>
					</tr>
				<?
				}
			?>
		</tbody>
	</table>
	<?if($allow_add):?>
	<div class="buttons">
		<a class="btn btn-primary" 
			 style="margin-top:14px; float:left; margin-left:15px" 
			 href="/admin/catalog/catalog/filters?action=create">
			 Добавить фильтр</a>
	</div>
	<?endif;?>
<?endif;?>






























<?if (($action=='create')||($action=='update')):?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'filter-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>false,
		'type' => 'vertical',
	)); 
	?>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>
	<?php echo $form->dropDownListRow($model,'charsname',$names_chars); ?>
	<?php echo $form->dropDownListRow($model,'type',$type_array); ?>
	<?php echo $form->dropDownListRow($model,'status',array('0'=>'Выключен','1'=>'Включен')); ?>

	<div>
	<?
	echo fn__get_checkbox_opts($categs_array,0,0,$categs_array_selected);
	?>

	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>'Сохранить',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Отмена',
			'url' =>'/admin/catalog/catalog/filters',
		)); ?>
	</div>
	
	<?php $this->endWidget(); ?>
<?endif;?>
