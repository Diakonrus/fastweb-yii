<h1 class="nopaddingtop" style="margin-top: 10px;"><?=$model->name?></h1>

<article>
    <p><?php echo date("d.m.Y", strtotime($model->maindate))?></p>
     <?php echo $model->description; ?>
</article>
