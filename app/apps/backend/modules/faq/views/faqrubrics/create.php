
<legend><?php echo Yii::t('Bootstrap', 'CREATE.FaqRubrics') ?></legend><?php echo $this->renderPartial('_form', array('model'=>$model, 'root' => $root, 'categories' => $categories, 'id' =>$id)); ?>