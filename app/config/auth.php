<?php

//Роли по умолчанию
$default =  array(

    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ),

    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Менеджер',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => array(
            'manager',
        ),
        'bizRule' => null,
        'data' => null
    ),


);


$result = array();
foreach (UserRole::model()->findAll() as $data){
    $result[$data->name] = array('type'=>CAuthItem::TYPE_ROLE, 'description' => $data->description, 'bizRule' => null, 'data' => null);
}


return ((!empty($result))?$result:$default);
