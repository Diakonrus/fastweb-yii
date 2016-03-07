<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$modelElements))); ?>
<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>


<h1 class="nopaddingtop" style="margin-top: 10px;"><?=$modelElements->name?></h1>

<article>
    <p><?php echo date("d.m.Y", strtotime($modelElements->maindate))?></p>
    <?php echo $modelElements->description; ?>
</article>
