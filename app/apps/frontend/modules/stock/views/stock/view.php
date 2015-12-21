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


        <HR>

        <table>
            <tbody>
            <tr>
                <td style="border-bottom:none;">
                    <br>
                    <br>
                    <br>
                    <h2 class="print_invisible">
                        <b>Смотрите также:</b>
                    </h2>
                    <?php
                    $request = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('{{stock}}')
                        ->where('id >= (SELECT FLOOR( MAX(id) * RAND()) FROM {{stock}} ) AND id not in ('.$model->id.') AND status=1')
                        ->limit(3)
                        ->queryAll();

                    foreach ( $request as $value ) {?>
                    <div class="new_list print_invisible" style="margin-top:10px;">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td valign="top">
                                    <a href="/stock/<?=$value['id'];?>">
                                        <img src="/uploads/filestorage/stock/elements/small-<?=$value['id'];?>.<?=$value['image'];?>">
                                    </a>
                                </td>
                                <td class="new_list_td" valign="top">
                                    <div class="data5" style="margin-bottom:4px;">14.06.2014 </div>
                                    <div class="tema5">
                                        <a href="/stock/<?=$value['id'];?>" title=""><?=$value['name'];?></a>
                                    </div>
                                    <div style="margin-top:2px;padding:0px"></div>
                                    <div>
                                        <?=$value['brieftext'];?>
                                    </div>
                                    <div></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<?php } ?>
                </td>
            </tr>
            
            </tbody>
        </table>

    </div>
</div>