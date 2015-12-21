
<legend>Сообщения</legend>


<div role="tabpanel">

    <ul class="nav nav-tabs" role="tablist">
        <li role="webmessages" class="active"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Входящие</a></li>
        <li role="webmessages"><a href="#outbox" aria-controls="outbox" role="tab" data-toggle="tab">Отправленные</a></li>
    </ul>

    <style>

        .messagesBox {
            margin-bottom: 20px;
            width: 100%;
            padding-bottom: 20px;
        }
        .messagesBox .title {
            background: #808080;
            border-radius:4px 4px 0 0;
            width: 100%;
            cursor: pointer;
        }
        .messagesBox .title .newMsg {
            color:#dc143c;
        }
        .messagesBox .body {
            clear: both;
            border-radius: 0px 0px 4px 4px;
            padding: 10px;
            background: #d3d3d3;
            display: none;
        }
        .messagesBox .body .readBoxTxt {
            position:absolute;
            padding:3px;
        }
        .messagesBox .body .actionBlock {
            clear: both;
            padding-top:10px;
        }
        .messagesBox .body .actionBlockAnswer{
            display: none;
        }

    </style>

    <div class="tab-content" id="tabListData">
        <div role="tabpanel" class="tab-pane active" id="inbox">

            <?php

                foreach ($model['inbox'] as $data){
                    echo '<div class="messagesBox">';

                        echo '
                        <div class="title">
                            '.$data->title.' [ '.date("d-m-Y H:i:s", strtotime($data->created_at)).' ]
                            '.(($data->read == 0)?'<span class="newMsg">Новое письмо</span>':'').'
                        </div>';
                        echo '
                        <div class="body">
                            '.$data->body.'
                            <hr>
                            '.(($data->read == 0)?'<div class="readBoxBlock"><input type="checkbox" data-id="'.$data->id.'" class="readBox"  /><span class="readBoxTxt">Отметить, как прочитанное</span></div>':'').'
                        ';

                        if ((int)$rule == 2 || (int)$rule == 3){
                            echo '<div class="actionBlock">';
                                //Можно отвечать
                                echo '<a href="#" class="btn showBlockAnswer">Ответить</a>';

                                //Можно удалять переписку
                                if((int)$rule == 3){
                                    echo '<a href="#" data-id="'.$data->id.'" class="btn btn-danger deleteBlockMsg" style="margin-left:10px;">Удалить</a>';
                                }


                            echo '</div>';
                            echo '<div class="actionBlockAnswer">';

                                Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

                                $this->widget('ImperaviRedactorWidget', array(
                                    'name' => '['.$data->id.']msg',
                                    'attribute' => 'body',

                                    'options' => array(
                                        'lang' => 'ru',
                                        'imageUpload' => Yii::app()->createAbsoluteUrl('/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/imageUpload'),
                                    ),
                                    'plugins' => array(
                                        'fullscreen' => array(
                                            'js' => array('fullscreen.js',),
                                        ),
                                        'video' => array(
                                            'js' => array('video.js',),
                                        ),
                                        'table' => array(
                                            'js' => array('table.js',),
                                        ),
                                        'fontcolor' => array(
                                            'js' => array('fontcolor.js',),
                                        ),
                                        'fontfamily' => array(
                                            'js' => array('fontfamily.js',),
                                        ),
                                        'fontsize' => array(
                                            'js' => array('fontsize.js',),
                                        ),
                                    ),
                                ));

                                echo '<a href="#" data-id="'.$data->id.'" class="btn btn-primary sendMsg" >Отправить</a>';

                            echo '</div>';
                        }



                        echo '</div>';
                    echo '</div>';
                    echo '<div style="clear: both;"></div>';
                }

            ?>

        </div>
        <div role="tabpanel" class="tab-pane" id="outbox">

            <?php
                foreach ($model['outbox'] as $data){
                    echo '<div class="messagesBox">';
                    echo '
                        <div class="title">
                            '.$data->title.' [ '.date("d-m-Y H:i:s", strtotime($data->created_at)).' ]
                            '.(($data->read == 0)?'<span class="newMsg">Новое письмо</span>':'').'
                        </div>';
                    echo '
                        <div class="body">
                            '.$data->body.'
                            ';
                    foreach ( WebsiteMessages::model()->findAll('delivery_name LIKE ("'.$data->delivery_name.'") AND recipient_id IN ('.$data->author_id.') ORDER BY id DESC') as $sub){
                        echo '
                            <HR style="border: 1px dashed">
                            <span>от <b>'.User::model()->findByPk($sub->author_id)->email.'</b> [ '.date("d-m-Y H:i:s", strtotime($data->created_at)).' ]</span></BR>'.
                            $sub->body;
                    }
                    echo '
                            <hr>
                            '.(($data->read == 0)?'<div class="readBoxBlock"><input type="checkbox" data-id="'.$data->id.'" class="readBox"  /><span class="readBoxTxt">Отметить, как прочитанное</span></div>':'').'
                        ';


                    echo '</div>';
                    echo '</div>';
                    echo '<div style="clear: both;"></div>';
                }
            ?>

        </div>
    </div>

</div>


<script>
    $(document).on('click', '.messagesBox .title', function(){
        $(this).next().slideToggle();
    });

    $(document).on('click', '.messagesBox .body .readBox', function(){
        var rowID = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: '/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            data: { type:'confRead', id:rowID }
        });
        $(this).parent().parent().parent().find('.newMsg').empty();
        $(this).parent().empty();

    });

    $(document).on('click', '.messagesBox .body .actionBlock .showBlockAnswer', function(){
        $(this).parent().next().slideToggle();
        return false;
    });

    $(document).on('click', '.body .actionBlockAnswer .sendMsg', function(){
        var rowID = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: '/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            data: { type:'answerMsg', id:rowID, msg:$("#_"+rowID+"msg").val() }
        });
        $(this).parent().slideToggle();

        return false;
    });

    $(document).on('click', '.messagesBox .actionBlock .deleteBlockMsg', function(){
        var rowID = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: '/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            data: { type:'deleteMsg', id:rowID }
        });
        $(this).parent().parent().parent().empty();
        return false;
    });

</script>