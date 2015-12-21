<div class="block_content">
    <div class="news">
        <h1>Новости</h1>

        <div>
            <br>
            <?php foreach ($model as $data){ ?>
            <div class="new_list">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                        <td valign="top">
                            <a title="<?=$data->name;?>" href="/news/<?=$data->id;?>">
                                <img alt="<?=$data->name;?>" src="/uploads/filestorage/news/elements/small-<?=$data->id;?>.<?=$data->image;?>">
                            </a>
                        </td>
                        <td class="new_list_td" valign="top">
                            <div class="data5"><?=date("d.m.Y", strtotime($data->maindate));?></div>
                            <div class="tema5">
                                <a href="/news/<?=$data->id;?>"><?=$data->name;?></a>
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
