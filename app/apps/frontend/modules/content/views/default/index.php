<div class="block-video mag-top--13">

    <aside class="left-col ">
        <h1 class="mg-top-24"><a href="/news">НОВОСТИ</a></h1>

        <?php if ($news=News::model()->getLastNews(true, 1, 1)) {
            foreach ($news as $data) { ?>

            <div class="left-tops clearfix">
                <div class="col-xs-4">
                    <div class="row">
                        <?php if (!empty($data->image)) { ?><img src="/uploads/filestorage/news/elements/<?=$data->id;?>.<?=$data->image;?>"><?php } ?>
                    </div>
                </div>
                <div class="col-xs-8">
                    <h1><?=News::model()->getDate($data->maindate);?></h1>
                    <a href="/news/<?=$data->id;?>"><p><?=$data->name;?></p></a>
                </div>
            </div>

        <?php }
        }
        ?>

        <h1 class="mg-bottom-10 mg-top-16"><a href="/sale">АКЦИИ</a></h1>

        <?php if ($sale=Sale::model()->getLastSales(true, 1, 1)) {
            foreach ($sale as $data) { ?>

                <div class="left-tops clearfix">
                    <div class="col-xs-4">
                        <div class="row">
                            <?php if (!empty($data->image)) { ?><img src="/uploads/filestorage/sale/elements/<?=$data->id;?>.<?=$data->image;?>"><?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <h1><?=date('d.m.Y', strtotime($data->maindate));?></h1>
                        <a href="/sale/<?=$data->id;?>"><p><?=$data->name;?></p></a>
                    </div>
                </div>

            <?php }
        }
        ?>

    </aside>

    <div class="video text-justify">
        <h1 class="mg-top-24">ВИДЕО:<span>Косметология</span><span>SPA</span><span>Пластическая хирургия</span></h1>

        <iframe width="481" height="250" src="https://www.youtube.com/embed/7NOpAwbGWIg" frameborder="0" allowfullscreen></iframe>
    </div>


</div>