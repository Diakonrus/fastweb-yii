<div class="block_content">
    <div class="news">
        <h1><?php echo $model->name; ?></h1>

        <table class="news_element" border="0">
            <tbody>
            <tr>
                <td valign="top" style="border-bottom:none;">
                    <div class="new">
                        <div class="maindate"><?php echo date("d.m.Y", strtotime($model->maindate)); ?></div>
                        <div class="description-news">
                            <p style="text-align: justify;">
                                <?php echo $model->description; ?>
                            </p>
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
                    $articles = News::model()->findAllByAttributes(
                        array(
                            'status' => 1
                        ),
                        array(
                            'limit' => 3
                        ));

                    foreach ( $articles as $data ) {?>
                    <div class="new_list print_invisible" style="margin-top:10px;">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td valign="top">
                                    <a href="/news/<?=$data->id;?>">
                                        <img src="/uploads/filestorage/news/elements/small-<?=$data->id;?>.<?=$data->image;?>">
                                    </a>
                                </td>
                                <td class="new_list_td" valign="top">
                                    <div class="data5" style="margin-bottom:4px;">14.06.2014 </div>
                                    <div class="tema5">
                                        <a href="/news/<?=$data->id;?>" title=""><?=$data->name;?></a>
                                    </div>
                                    <div style="margin-top:2px;padding:0px"></div>
                                    <div>
                                        <?=$data->brieftext;?>
                                    </div>
                                    <div></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
