<?php
$this->breadcrumbs=array(
	'Feedback Subjects',
);

$this->menu=array(
	array('label'=>'Create FeedbackSubject','url'=>array('create')),
	array('label'=>'Manage FeedbackSubject','url'=>array('admin')),
);
?>

<h1>Feedback Subjects</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
