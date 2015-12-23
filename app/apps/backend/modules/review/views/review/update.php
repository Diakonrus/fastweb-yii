<legend><?php echo Yii::t('Bootstrap', 'UPDATE.Review') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.ReviewElements') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true 
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model, 'root'=>$root, 'catalog' => $catalog)); ?>