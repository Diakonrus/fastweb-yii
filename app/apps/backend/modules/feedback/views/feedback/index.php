<?php
$this->breadcrumbs=array(
	$this->module->t('Phrases', 'MODULE.BREADCUMBS.FEEDBACKS'),
);

$this->menu=array(
	array('label'=>$this->module->t('Phrases', 'MODULE.MENU.CREATE_FEEDBACK') ,'url'=>array('create')),
	array('label'=>$this->module->t('Phrases', 'MODULE.MENU.MANAGE_FEEDBACK'), 'url'=>array('admin')),
);
?>

<h1>Feedbacks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
