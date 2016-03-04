<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>

<table class="moduletable" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<!-- Выводим группы новостей -->
			<?php foreach ( $model['group'] as $data ) { ?>
                <div class="menuinside3"><a href="<?=Pages::returnUrl($data->url);?>"><?=$data->name;?></a></div>
			<?php } ?>
		</td>
	</tr>
</table>

<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>

    <!-- Выводим новости без групп -->
    <section>
        <div class="news-block">
            <main role="main" class="all">
                <div class="">
                    <?php $i = 0; ?>
                    <?php foreach ( $model['no_group'] as $data ) { ?>
                        <?php ++$i;?>
                        <?php if ($i%2!=0){ echo '<div class="press-line">'; }?>
                            <?=NewsGroup::model()->returnDesignElement($data);?>
                        <?php if ($i%2==0){ echo '</div>'; }?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </section>
