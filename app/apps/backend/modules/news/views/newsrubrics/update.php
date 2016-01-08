<legend><?php echo Yii::t('Bootstrap', 'UPDATE.NewsRubrics') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.NewsRubrics') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model, 'root' => $root,'categories' => $categories, 'id'=>$id)); ?>