<div class="block_content">
    <div class="stock">
        <h1><?php echo $model->name; ?></h1>

        <table class="stock_element" border="0">
            <tbody>
            <tr>
                <td valign="top" style="border-bottom:none;">
                    <div class="new">
                        <div class="maindate"><?php echo date("d.m.Y", strtotime($model->maindate)); ?></div>
                        <div class="description-stock">
                            <a class="group" href="/uploads/filestorage/stock/elements/medium-<?=$model->id;?>.<?=$model->image?>" target="_blank" rel="example_group2">
                            <img src="/uploads/filestorage/stock/elements/small-<?=$model->id;?>.<?=$model->image?>" style="float: left; margin: 5px 10px;" alt="">
                            </a>
                                <?php echo $model->description; ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>
</div>