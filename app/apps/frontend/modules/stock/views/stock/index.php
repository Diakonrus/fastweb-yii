<div class="block_content">
    <div class="stock">
        <h1>Статьи</h1>

        <div>
            <br>
            <?php foreach ($model as $data){ ?>
            <div class="new_list">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                        <td valign="top">
                            <a title="<?=$data->name;?>" href="<?=Yii::app()->request->requestUri;?>/<?=$data->id;?>">
                                <img alt="<?=$data->name;?>" src="/uploads/filestorage/stock/elements/small-<?=$data->id;?>.<?=$data->image;?>">
                            </a>
                        </td>
                        <td class="new_list_td" valign="top">
                            <div class="data5"><?=date("d.m.Y", strtotime($data->maindate));?></div>
                            <div class="tema5">
                                <a href="<?=Yii::app()->request->requestUri;?>/<?=$data->id;?>"><?=$data->name;?></a>
                            </div>
                            <div class="text5">
                                <p style="text-align: justify;"><?=$data->brieftext;?></p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>


</div>
