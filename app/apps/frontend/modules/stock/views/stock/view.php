<?=$this->widget('application.apps.frontend.components.Categories',array(), TRUE)?>
<?php $this->widget('application.extensions.Breadcrumbs.Breadcrumbs', array('params'=>array('model'=>$model))); ?>

<h1 class="lined nopaddingtop" style="margin-top: 10px;"><?=Pages::getTitle()?></h1>

<div class="block_content">
    <div class="stock">
        <div class="_page_title">
            <h1><?php echo $model->name; ?></h1>
        </div>


        <table class="stock_element" border="0">
            <tbody>
            <tr>
                <td valign="top" style="border-bottom:none;">
                    <div class="new">
                        <div class="maindate"><?php echo date("d.m.Y", strtotime($model->maindate)); ?></div>
                        <div class="description-stock">

                                <?php echo $model->description; ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>
</div>