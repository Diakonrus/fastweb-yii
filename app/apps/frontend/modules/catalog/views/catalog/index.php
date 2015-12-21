<?php

foreach ($descendants as $category){
    echo '<li class="ul_menu_lefl">';
    //Получаем подкатегории
    $category_sub = CatalogRubrics::model()->findByPk($category['id']);
    $category_sub = $category_sub->descendants(1)->findAll();
    if ($category_sub){
        echo '<a onclick="$(this).next().toggle(); $(this).find(\'plus_li\').toggleClass(\'plus_li_active\');" href="javascript:void(0);">' . $category['name'] . '</a>';

        echo '<ul style="padding-left: 0px; margin-left: 0px; list-style-type: none; display:none;">';
        foreach ($category_sub as $sub_catalog){

            echo '<li>';

            //Смотрим, есть ли еще субкаталог
            if ($category_sub2 = CatalogRubrics::model()->findByPk($sub_catalog['id'])->descendants(1)->findAll()){
                echo '<a id="'.$sub_catalog['id'].'" onclick="$(this).next().toggle(); $(this).find(\'plus_li\').toggleClass(\'plus_li_active\');" title="" href="javascript:void(0);">'.$sub_catalog['name'].'</a>';
                echo '<ul>';
                foreach ($category_sub2 as $sub_catalog2){
                    echo '<li>';
                    echo '<a id="'.$sub_catalog2['id'].'" title="" href="/catalog/'.$category['url'].'/'.$sub_catalog['url'].'/'.$sub_catalog2['url'].'/">' . $sub_catalog2['name'] . '</a>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '<span class="plus_li" style="width: 10px;"> </span>';
            } else {
                echo '<a id="'.$sub_catalog['id'].'" title="" href="/catalog/'.$category['url'].'/'.$sub_catalog['url'].'/">'.$sub_catalog['name'].'</a>';
            }

            echo '</li>';

        }
        echo '</ul>';
        echo '<span class="plus_li" item-data="1-1"> </span>';
    }else {
        //Если нет подкатегорий - сразу делаем ссылкой
        echo '<a href="/catalog/'.$category['url'].'/">'.$category['name'].'</a>';
    }


    echo '</li>';

    //echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']), $category['name'];
    //echo '<BR>';
}

?>