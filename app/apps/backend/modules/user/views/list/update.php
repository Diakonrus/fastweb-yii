<legend><?php echo Yii::t('Bootstrap', 'UPDATE.User') . ' #' . $model->id ?></legend>
<?php echo $this->renderPartial('_form',array('model'=>$model));