<legend><?php echo Yii::t('Bootstrap', 'UPDATE.BanersRubrics') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.BanersRubrics') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true 
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model, 'root' => $root, 'categories' => $categories, 'id' =>$id)); ?>