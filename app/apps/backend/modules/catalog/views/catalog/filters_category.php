
<?if ($action=='list'):?>
	<table class="table table-striped table-bordered table-hover"  cellspacing="0">
		<thead>
			<tr>
				<th style="text-align:center; width:21px">
					#
				</th>
				<th>Название категории</th>
				<th>Количество фильтров</th>
				<th width="10" nowrap="" style="width: 90px;">Статус</th>
				<th nowrap="" colspan="4" style="width: 20px;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($model_filters_category as $model_filters_category_item)
				{
				?>
					<tr>
						<td class="n1">
							<?=$model_filters_category_item->id?>
						</td>
						<td><?=$model_filters_category_item->name?></td>
						<td><?=$counts[$model_filters_category_item->id]?></td>
						<td style="text-align:center;"><?=(($model_filters_category_item->status)?'Вкл':'Выкл')?></td>
						<td style="width: 20px; text-align:center;">
							<a href="/admin/catalog/catalog/filters_category?action=update&id=<?=$model_filters_category_item->id?>" 
								 data-toggle="tooltip" 
								 title="" 
								 data-original-title="Редактировать категорию">
								<i class="icon-pencil"></i>
							</a>
						</td>
					</tr>
				<?
				}
			?>
		</tbody>
	</table>
	<div class="buttons">
		<a class="btn btn-primary" 
			 style="margin-top:14px; float:left; margin-left:15px" 
			 href="/admin/catalog/catalog/filters_category?action=create">
			 Добавить категорию</a>
	</div>
<?endif;?>






























<?if (($action=='create')||($action=='update')):?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'filter_category_form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>false,
		'type' => 'vertical',
	)); 
	?>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>
	<?php echo $form->dropDownListRow($model,'status',array('0'=>'Выключен','1'=>'Включен')); ?>

	
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
			'url' =>'/admin/catalog/catalog/filters_category',
		)); ?>
	</div>
	
	<?php $this->endWidget(); ?>
<?endif;?>
