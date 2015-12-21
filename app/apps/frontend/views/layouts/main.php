<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script src="/js/jquery-2.1.3.js"></script>
    <script src="/js/main.js"></script>

    <link rel="stylesheet" type="text/css" href="/js/select2/select2.css" />

    <link rel="stylesheet" href="/js/bootstrap-select/css/bootstrap-select.css">
    <script src="/js/bootstrap-select/js/bootstrap-select.js"></script>

    <script src="/js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />


</head>

<body>

<div id="warp">
    <div id="content">
        <header>
            <div class="container">
                <div class="row">
                    <!-- Вставляем шаблон темплейта меню -->

                </div>
            </div>

        </header>
        <div class="content">
            <div class="container padding">
                <div class="row">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="basket_h" class="print_invisible">
    <div id="bas_shader"></div>
    <div id="bas_centered_box">
        <div id="textbox_2" class="print_invisible">
            <div id="bas_warning_title">Товар добавлен в корзину</div>
            <div id="bas_warning_text"><a class="order" href="/basket/" onclick="set_basket();">Перейти в корзину</a>
                &nbsp;<a class="order" href="javascript:void(0);" onClick=" get_basket_count(); $('#basket_h').hide();">Продолжить
                    покупки</a></div>
        </div>
    </div>
</div>

</body>
</html>
