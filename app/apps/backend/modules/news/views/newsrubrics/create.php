
<legend><?php echo Yii::t('Bootstrap', 'CREATE.NewsRubrics') ?></legend><?php echo $this->renderPartial('_form', array('model'=>$model, 'root' => $root,
    'categories' => $categories, 'id'=>$id)); ?>