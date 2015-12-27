
<legend><?php echo Yii::t('Bootstrap', 'CREATE.ArticleElements') ?></legend><?php echo $this->renderPartial('_form', array('model'=>$model, 'root'=>$root, 'catalog' => $catalog)); ?>