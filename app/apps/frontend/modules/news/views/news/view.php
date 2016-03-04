<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>
<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>


<h1 class="nopaddingtop" style="margin-top: 10px;"><?=$model->name?></h1>

<article>
    <p><?php echo date("d.m.Y", strtotime($model->maindate))?></p>
     <?php echo $model->description; ?>
</article>
