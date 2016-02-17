<?php /* @var $this Controller */ ?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="/js/select2/select2.css" />
    <script type="text/javascript" src="/js/select2/select2.min.js"></script>
    <script type="text/javascript" src="/js/admin/iColorPicker.js"></script>
    <link rel="stylesheet" type="text/css" href="/admin/css/style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="/js/jquery.maskedinput.js" type="text/javascript"></script>
</head>

<body>

<div class="head"><div class="head_l">
        <a class="logo" href="/admin" title=""><img src="/images/admin/logo.png" alt="" /></a>
        <a class="exit" href="/admin/user/login/logout" title="">Выход</a>
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
        <!--<img src="/images/admin/strela.gif" alt="" /><a href="#" title="">Администрирование</a> / <a href="#" title="">Списки пользователей</a> / <a href="#" title="">Alex FastWeb</a> / Правила доступа-->
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
                            <li><a href="/admin/user/list/role" title=""><img src="/images/admin/strela2.gif" alt="" /> Группы пользователей </a></li>
                        </ul>
                    </li>
                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic6.gif" alt="" /></span> <a href="#" title="">Структура сайта  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/pages/pages" title=""><img src="/images/admin/strela2.gif" alt="" /> Дерево</a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic3.gif" alt="" /></span> <a href="#" title="">Каталог  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/catalog/catalog/listgroup" title=""><img src="/images/admin/strela2.gif" alt="" />Каталоги</a></li>
                            <li><a href="/admin/catalog/catalog/listelement" title=""><img src="/images/admin/strela2.gif" alt="" />Товары</a></li>
                            <li><a href="/admin/catalog/catalog/sharechars" title=""><img src="/images/admin/strela2.gif" alt="" />Общие характеристики</a></li>
<li>
	<a href="/admin/catalog/catalog/filters" title="">
		<img src="/images/admin/strela2.gif" alt="" />
		Фильтры
	</a>
</li>
                        </ul>
                    </li>

                    <li  class="left-menu-title"><span><img src="/images/admin/basket.gif" alt="" /></span> <a href="#" title="">Магазин  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/basket/basket/orders" title=""><img src="/images/admin/strela2.gif" alt="" />Заказы</a></li>
                            <li><a href="/admin/basket/basket/stat" title=""><img src="/images/admin/strela2.gif" alt="" />Статистика</a></li>
                            <li><a href="/admin/catalog/CatalogElementsDiscount" title=""><img src="/images/admin/strela2.gif" alt="" />Скидки</a></li>
                        </ul>
                    </li>

                    <li class="left-menu-title"><span><img src="/images/admin/loadxml.gif" alt="" /></span> <a href="#" title="">Загрузки XML  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/loadxml/loadxml/index" title=""><img src="/images/admin/strela2.gif" alt="" />Профиль</a></li>
                            <li><a href="/admin/loadxml/loadxml/create" title=""><img src="/images/admin/strela2.gif" alt="" />Конструктор профиля</a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 7 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic25.png" alt="" /></span> <a href="#" title="">Вопрос-ответ  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/faq/faqrubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список тем вопросов</a></li>
                            <li><a href="/admin/faq/faqauthor/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список авторов вопросов</a></li>
                            <li><a href="/admin/faq/faq/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список вопросов-ответов</a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 7 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic32.png" alt="" /></span> <a href="#" title="">HTML код  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/htmlcode/htmlcode/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список записей</a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 7 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic31.png" alt="" /></span> <a href="#" title="">Отзывы  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/review/reviewrubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список категорий</a></li>
                            <li><a href="/admin/review/reviewauthor/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список авторов отзывов</a></li>
                            <li><a href="/admin/review/review/index" title=""><img src="/images/admin/strela2.gif" alt="" />Список отзывов</a></li>
                        </ul>
                    </li>

                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic12.gif" alt="" /></span> <a href="#" title="">Сервисы почты </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/messages/messages" title=""><img src="/images/admin/strela2.gif" alt="" /> Отправить письмо на Email  </a></li>
                            <li><a href="/admin/messages/emailtemplate" title=""><img src="/images/admin/strela2.gif" alt="" /> Шаблоны  </a></li>
                        </ul>
                    </li>
                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 1 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic2.gif" alt="" /></span> <a href="#" title="">Новости </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/news/newsrubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список групп </a></li>
                            <li><a href="/admin/news/newselements" title=""><img src="/images/admin/strela2.gif" alt="" /> Список новостей  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 14 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic2.gif" alt="" /></span> <a href="#" title="">Пресса о нас </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/press/pressgroup/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список групп прессы  </a></li>
                            <li><a href="/admin/press" title=""><img src="/images/admin/strela2.gif" alt="" /> Список записей  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 9 AND `status`=0'))?(' display:none; '):(''));?>"  class="left-menu-title"><span><img src="/images/admin/icons/ic28.png" alt="" /></span> <a href="#" title="">Акции </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/sale/salegroup/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список групп акций  </a></li>
                            <li><a href="/admin/sale" title=""><img src="/images/admin/strela2.gif" alt="" /> Список акций  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 10 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic29.png" alt="" /></span> <a href="#" title="">Врачи </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/doctor/doctorrubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список специализаций врачей  </a></li>
                            <li><a href="/admin/doctor/doctorelements/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список врачей  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 6 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/articles.gif" alt="" /></span> <a href="#" title="">Статьи </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/article/articlerubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список категорий  </a></li>
                            <li><a href="/admin/article/articleelements" title=""><img src="/images/admin/strela2.gif" alt="" /> Список статей  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 12 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic5.gif" alt="" /></span> <a href="#" title="">До и После </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/beforeafter/beforeafterrubrics" title=""><img src="/images/admin/strela2.gif" alt="" /> Список групп  </a></li>
                            <li><a href="/admin/beforeafter/beforeafterelements" title=""><img src="/images/admin/strela2.gif" alt="" /> Список элементов  </a></li>
                        </ul>
                    </li>



                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 11 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic5.gif" alt="" /></span> <a href="#" title="">Фотоальбом </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/photo/photorubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список альбомов  </a></li>
                            <li><a href="/admin/photo/photo/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список фотографий  </a></li>
                            <li><a href="/admin/photo/phototemplate" title=""><img src="/images/admin/strela2.gif" alt="" /> Шаблон фотогалереи  </a></li>
                        </ul>
                    </li>

                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic21.gif" alt="" /></span> <a href="#" title="">Обратная связь </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/feedback" title=""><img src="/images/admin/strela2.gif" alt="" /> Список обращений  </a></li>
                        </ul>
                    </li>


                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 13 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic22.gif" alt="" /></span> <a href="#" title="">Таблицы </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/maintabel/maintabel/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список таблиц  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 15 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic30.png" alt="" /></span> <a href="#" title="">Банеры </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/baners/banersrubrics/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список групп банеров  </a></li>
                            <li><a href="/admin/baners/baners/index" title=""><img src="/images/admin/strela2.gif" alt="" /> Список банеров  </a></li>
                        </ul>
                    </li>

                    <li style="<?=((SiteModuleSettings::model()->find('site_module_id = 15 AND `status`=0'))?(' display:none; '):(''));?>" class="left-menu-title"><span><img src="/images/admin/icons/ic23.gif" alt="" /></span> <a href="#" title="">Конструктор форм</a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/forms/creatingformrubrics" title=""><img src="/images/admin/strela2.gif" alt="" /> Список форм  </a></li>
                            <li><a href="/admin/forms/creatingformelements" title=""><img src="/images/admin/strela2.gif" alt="" /> Список полей форм  </a></li>
                        </ul>
                    </li>

                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic22.png" alt="" /></span> <a href="#" title="">Яндекс метки  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/yandexmap/yandexmap" title=""><img src="/images/admin/strela2.gif" alt="" /> Добавить/удалить точку</a></li>
                        </ul>
                    </li>

                    <li class="left-menu-title"><span><img src="/images/admin/icons/ic13.gif" alt="" /></span> <a href="#" title="">Настройки  </a></li>
                    <li class="no">
                        <ul>
                            <li><a href="/admin/setting/sitemodulesettings" title=""><img src="/images/admin/strela2.gif" alt="" /> Модули сайта</a></li>
                        </ul>
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

<script src="/js/admin/script.js" type="text/javascript"></script>
<div class="foot">
    <p class="copy">версия 1.5y</p>
    <a class="logo2" href="#" title=""><img src="/images/admin/logo2.gif" alt="" /></a>
</div>
</body>
</html>
