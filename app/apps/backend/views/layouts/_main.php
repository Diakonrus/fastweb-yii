<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="/admin/css/style.css" />
</head>

<body>

<div class="head"><div class="head_l">
        <a class="logo" href="#" title=""><img src="/images/admin/logo.png" alt="" /></a>
        <a class="exit" href="/user/logout" title="">Выход</a>
        <div class="search">
            <a href="#" title=""><img src="/images/admin/go.gif" alt="" /></a>
            <div class="inp">
                <span><?=Yii::app()->user->name;?></span>
            </div>
        </div>
    </div></div>
<div class="line">
    <p class="title">Панель управления</p>
    <div class="link">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                        )); ?><!-- breadcrumbs -->
        <?php endif?>
        <img src="/images/admin/strela.gif" alt="" /> <a href="#" title="">Администрирование</a> / <a href="#" title="">Списки пользователей</a> / <a href="#" title="">Alex FastWeb</a> / Правила доступа
    </div>
</div>
<div class="content">
    <table class="main" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td class="left">
                <ul class="menu">

                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic1.gif" alt="" /></span> <a href="#" title="">Пользователи сайта</a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/user/" title=""><img src="/images/admin/strela2.gif" alt="" /> Списки пользователей  </a></li>
                            <li><a href="/admin/user/list/create" title=""><img src="/images/admin/strela2.gif" alt="" /> Добавить пользователя  </a></li>
                            <li><a href="/admin/feedback/feedback/admin" title=""><img src="/images/admin/strela2.gif" alt="" /> Обратная связь</a></li>
                        </ul>
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic2.gif" alt="" /></span> <a href="#" title="">Новости </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/news" title=""><img src="/images/admin/strela2.gif" alt="" /> Список новостей  </a></li>
                            <li><a href="/admin/news/news/create" title=""><img src="/images/admin/strela2.gif" alt="" /> Добавить новость  </a></li>
                        </ul>
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic16.gif" alt="" /></span> <a href="#" title="">Импорт данных в БД </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/importxls/importxls" title=""><img src="/images/admin/strela2.gif" alt="" /> Загрузить  </a></li>
                        </ul>
                    </li>





                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic3.gif" alt="" /></span> <a href="#" title="">Каталог </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic4.gif" alt="" /></span> <a href="#" title="">Управление заказами </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic5.gif" alt="" /></span> <a href="#" title="">Фотогалерея </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic6.gif" alt="" /></span> <a href="#" title="">Структура сайта </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic7.gif" alt="" /></span> <a href="#" title="">Мультимедиа </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic8.gif" alt="" /></span> <a href="#" title="">Файловый архив </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic9.gif" alt="" /></span> <a href="#" title="">HTML Карты/видео </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic10.gif" alt="" /></span> <a href="#" title="">Таблицы  </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic11.gif" alt="" /></span> <a href="#" title="">RSS подписки </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic12.gif" alt="" /></span> <a href="#" title="">Сервисы почты </a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic13.gif" alt="" /></span> <a href="#" title="">Опции</a></li>
                    <li class="no">
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic14.gif" alt="" /></span> <a href="#" title="">Модули сайта </a></li>
                    <li class="no">
                    </li>
                </ul>
            </td>
            <td class="right">
                <div class="container" id="page">

                    <?php echo $content; ?>
                    <div class="clear"></div>

                </div><!-- page -->
            </td>
        </tr>
    </table>
</div>
