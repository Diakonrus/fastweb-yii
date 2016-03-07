<style>
    a i {
        color:#0000ff;
    }
</style>
<table class="content_table hover_table" id="listgrouptable" cellspacing="0">
        <thead>
        <tr>
            <th style="text-align:center; width:21px">
                <input type="checkbox" onclick="if(this.checked) {selectall()} else {unselectall();}">
            </th>
            <th> Название раздела</th>
            <th width="10" nowrap=""> Позиций</th>
            <th width="10" nowrap="">Статус</th>
            <th nowrap="" colspan="4" style="width: 120px;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = 0;
            $level = 0;

            foreach ( $categories as $root_category ) {
                ++$i;
                $level = $root_category->level;

        ?>
        <tr class="<?php echo (($i%2)?'':' d2 ');  ?> elemets_row_<?=$root_category->id;?>" >

            <td class="n1">
                <input class="selectCategory" data-id="<?=$root_category->id;?>" style="margin-left:5px;" type="checkbox">
            </td>
            <td style="padding-left: 25px;vertical-align:middle;" class="level_<?=$level;?>">
                <span class="name" style="font-weight:bold;" >
                    <a href="#" class="link_sub_catalog" data-status="1" data-id="<?=$root_category->id;?>" style="color:#000000; text-decoration:underline;">
                        <span><img src="/images/admin/icons/plus.gif" ; style="width:15px;"></span>
                        <?=(($root_category->level==1)?('/'):($root_category->name));?></a>
                </span>
                <br>
                <a class="page_url"   style="margin-left:25px;" href="<?=$base_patch;?>/<?=(($root_category->level==1)?(''):($root_category->url));?>" target="_preview">
                    <span class="tree"></span>
                    <?=$base_patch;?>/<?=(($root_category->level==1)?(''):($root_category->url));?>
                </a>
            </td>
            <td nowrap="" style="text-align: center; font-weight: bold;">
                <a href="/admin/catalog/catalog/listelement?filterData=<?=$root_category->id;?>" style="color:#000000; text-decoration:underline;"><?= CatalogElements::getTotalCountElement($root_category);?></a>
            </td>
            <td nowrap="" style="text-align: center;">
                <a href="#" class="on-off-category" data-id="<?=$root_category->id;?>" data-status="<?=$root_category->status;?>">
                    <div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:<?=($root_category->status==1)?'green':'red';?>;"></div>
                </a>
            </td>
            <td width="1" style="min-width:120px;">

                <a href="/admin/catalog/catalog/create?id=<?=$root_category->id;?>" data-toggle="tooltip" title="" data-original-title="Добавить подкатегорию">
                    <i class="icon-file"></i>
                </a>
                <a href="/admin/catalog/catalog/update?id=<?=$root_category->id;?>" data-toggle="tooltip" title="" data-original-title="Редактировать категорию">
                    <i class="icon-pencil"></i>
                </a>

                <a href="/admin/catalog/catalog/listchars?id=<?=$root_category->id;?>" data-toggle="tooltip" title="" data-original-title="Редактировать свойства">
                    <i class="icon-cog"></i>
                </a>

                <a data-toggle="tooltip" title="" data-original-title="Переместить выше" title="" href="/admin/catalog/catalog/move?id=<?=$root_category->id;?>&move=1" style="<?=($i==1)?'display:none;':'';?>" >
                    <i class="icon-arrow-up"></i>
                </a>
                <a data-toggle="tooltip" title="" data-original-title="Переместить вниз" href="/admin/catalog/catalog/move?id=<?=$root_category->id;?>&move=2" style="<?=($i==count($categories))?'display:none;':'';?>" >
                    <i class="icon-arrow-down"></i>
                </a>

                <?php if($root_category->level > 1): ?>
                <a class="delete" href="/admin/catalog/catalog/delete?id=<?=$root_category->id;?>" data-toggle="tooltip" title="" data-original-title="Удалить">
                    <i class="icon-trash"></i>
                </a>
                <?php endif; ?>

                <!--
                <a title="Удалить" href="/adm/catalogTransmission/rubrics/edit/86/">
                    <img width="20px" border="0" height="20px" src="/images/admin/ico_up.gif" title="Редактировать" alt="Редактировать">
                </a>
                <a title="Редактировать категорию" href="/adm/catalogTransmission/rubrics/edit/86/">
                    <img width="20px" border="0" height="20px" src="/images/admin/ico_down.gif" title="Редактировать" alt="Редактировать">
                </a>
                -->
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>

<div id="ajax_loader" style="display: none;"><img width="40px;" style="position:absolute; margin-top:10px; margin-left:-40px;" src="/images/admin/ajaxloader.gif"></div>
<div class="buttons">
    <?php if (isset($_GET['id']) && $_GET['id']>0){ ?><a class="btn" style="float:left; margin-top:14px" href="/admin/catalog/catalog/listgroup?id=<?=CatalogRubrics::model()->findByPk((int)$_GET['id'])->parent_id;?>">&#9668; Назад</a><?php } ?>
    <a class="btn btn-primary" style="margin-top:14px; float:left; margin-left:15px" href="/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/create?id=<?=(isset($_GET['id']))?(int)$_GET['id']:0;?>"> Добавить группу</a>
    <a class="btn btn-danger" style="float:left; margin-left:15px; margin-top:14px" href="javascript: deleteselected();">Удалить отмеченные</a>
</div>


<?php
    $moduleSettings = SiteModuleSettings::model()->find('site_module_id = 4');
?>
<script>
    function selectall(){
       $('.selectCategory').prop('checked', true);
    }
    function unselectall(){
        $('.selectCategory').prop('checked', false);
    }

    //Меняем статус
    $(document).on('click', '.on-off-category', function(){
        $.ajax({
            type: 'POST',
            url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
            dataType: "json",
            data: {type:1, id:$(this).data('id')}
        });
        var status = $(this).data('status');
        $(this).find('div').css('background',((status==1)?'red':'green'));
        $(this).data('status', ((status==1)?0:1));
        return false;
    });

    //Удаляем отмеченые
    function deleteselected(){
        var arr = [];
        $('table tbody input:checkbox:checked').each(function(){
            arr.push($(this).data('id'));
        });
        if ( arr.length != 0 ){
            $('#ajax_loader').show();
            $.ajax({
                type: 'POST',
                url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajax',
                dataType: "json",
                data: {type:2, id:arr},
                success: function(data) {
                    $("#listgrouptable").load(document.location.href+" #listgrouptable");
                    $('#ajax_loader').hide();
                    alert('Записи удалены');
                }
            });
        }
    }



    //Подгружаем подкатегориии
    $(document).on('click','.link_sub_catalog',function(){
        var parent_id = $(this).data('id');

        $(this).data('status', (($(this).data('status')==1)?(0):(1)));

        if ($(this).data('status') == 1){
            $(this).parent().parent().find('img').attr('src','/images/admin/icons/plus.gif');
        }
        else {             $(this).parent().parent().find('img').attr('src','/images/admin/icons/minus.gif'); }

        if($(this).data('status') == 1){
            $('.delete_row_'+parent_id).remove();
        } else {
            $.ajax({
                type: 'POST',
                url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxuploadcatalog',
                dataType: "json",
                data: {id:parent_id},
                success: function(dataResult) {
                    //console.log(dataResult);
                    var html = '';
                    var num_row = 0;
                    $.each( dataResult['data'], function( id, data ) {
                        console.log(data['url']);
                        var delete_class = '';
                        $.each( data['parent_id'], function( parent_id, parent_data ) {
                            delete_class += ' delete_row_'+parent_data;
                        });

                        html += '<tr class="elemets_row_'+id+' '+delete_class+'">';
                        html += '<td class="n1"> ' +
                            '<input class="selectCategory" type="checkbox" style="margin-left:5px;" data-id="'+id+'"> ' +
                            '</td>';
                        var shift = '';
                        for (var i = 0; i < data['level']; i++) {
                            shift += '&nbsp;&nbsp;';
                        }
                        html += '<td class="level_2" style="padding-left: 25px;vertical-align:middle;"> ' +
                            '<span class="name" style="font-weight:bold;"> ' +
                            ''+shift+'<a class="link_sub_catalog" style="color:#000000; text-decoration:underline;" data-status="1" data-id="'+id+'" href="#">' +
                            '<span>' +
                            '<img style="width:15px;" ;="" src="/images/admin/icons/plus.gif">' +
                            '</span>'+data['name']+'</a> ' +
                            '</span> ' +
                            '<br> ' +
                            '<a class="page_url" target="_preview" href="'+data['url']+'"> ' +
                            '<span class="tree"></span>' +
                            '<p>'+shift+''+data['url']+'</p>'+
                            '</a></td>' +
                            '<td nowrap="" style="text-align: center; font-weight: bold;">' +
                            '<a href="/admin/catalog/catalog/listelement?filterData='+id+'" style="color:#000000; text-decoration:underline;">'+data['count_poz']+'</a>' +
                            '</td>' +
                            '<td style="text-align: center;">' +
                            '<a class="on-off-category" data-status="'+data['status']+'" data-id="'+id+'" href="#"><div style="margin-left:20px; width: 13px; height: 13px; border-radius: 3px; background:'+((data['status']==1)?('green'):('red'))+';"></div></a>' +
                            '</td>' +
                            '<td>' +
                            '<a data-original-title="Добавить подкатегорию" title="" data-toggle="tooltip" href="/admin/catalog/catalog/create?id='+id+'"> ' +
                            '<i class="icon-file"></i> ' +
                            '</a>' +
                            '<a data-original-title="Редактировать категорию" title="" data-toggle="tooltip" href="/admin/catalog/catalog/update?id='+id+'">' +
                            '<i class="icon-pencil"></i> ' +
                            '</a>'+
                            '<a data-original-title="Редактировать свойства" title="" data-toggle="tooltip" href="/admin/catalog/catalog/listchars?id='+id+'">' +
                            '<i class="icon-cog"></i> ' +
                            '</a>'+
                            '<a href="/admin/catalog/catalog/move?id='+id+'&move=1" data-original-title="Переместить выше" title="" style="'+((num_row==0)?('display:none;'):(''))+'" data-toggle="tooltip">' +
                            '<i class="icon-arrow-up"></i> ' +
                            '</a>'+
                            '<a href="/admin/catalog/catalog/move?id='+id+'&move=2" data-original-title="Переместить вниз" title="" style="'+((num_row==(dataResult['total']-1))?('display:none;'):(''))+'" data-toggle="tooltip">' +
                            '<i class="icon-arrow-down"></i> ' +
                            '</a>'+
                            '<a class="delete" data-original-title="Удалить" title="" data-toggle="tooltip" href="/admin/catalog/catalog/delete?id='+id+'">' +
                            '<i class="icon-trash"></i> ' +
                            '</a>'+
                            '</td>';



                        html += '</tr>';

                        ++num_row;
                    });
                    $('.elemets_row_'+parent_id).eq(0).after(html);

                    <?php if ( !empty($moduleSettings->type_list) && $moduleSettings->type_list == 1   ){ ?>  $('.link_sub_catalog').click(); <?php } ?>
                }
            });
        }


        return false;
    });




    <?php if ( !empty($moduleSettings->type_list) && $moduleSettings->type_list == 1   ){ ?>  $('.link_sub_catalog').click(); <?php } ?>




</script>