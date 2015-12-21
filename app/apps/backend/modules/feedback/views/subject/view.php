<?php
$this->breadcrumbs=array(
	'Feedback Subjects'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List FeedbackSubject','url'=>array('index')),
	array('label'=>'Create FeedbackSubject','url'=>array('create')),
	array('label'=>'Update FeedbackSubject','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete FeedbackSubject','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FeedbackSubject','url'=>array('admin')),
);
?>

<h1>View FeedbackSubject #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
