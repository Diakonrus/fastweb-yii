<legend><?php echo Yii::t('Bootstrap', 'UPDATE.ReviewRubrics') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.ReviewRubrics') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true 
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model, 'root' => $root, 'categories' => $categories, 'id' =>$id)); ?>