$(document).ready(function(){

    $(document).on('click','.block_url', function(){
        var type = $(this).find('a').data('type');
        if (type=='plus'){$(this).find('img').attr('src','/images/admin/icons/minus.gif'); $(this).find('a').data('type','minus');}
        else {$(this).find('img').attr('src','/images/admin/icons/plus.gif'); $(this).find('a').data('type','plus');}
        $(this).next().slideToggle();
        return false;
    });

    //кнопки в меню
    $(document).on('click', '.left-menu-title', function(){
        $(this).next().slideToggle();
        return false;
    });

    //выводим открытый пункт меню
    var tmp_url = location.href.split('/');
    var tmp_url_link = '/'+tmp_url[3]+'/';
    if(5 in tmp_url){
        tmp_url_link += tmp_url[4]+'/'+(tmp_url[5].replace(/#/g, ""));
    } else {
        tmp_url_link += (tmp_url[4].replace(/#/g, ""));
    }
    if (tmp_url_link.length>7){
        $("a[href^='"+tmp_url_link+"']").parent().parent().parent().show();
    }

    //Транслит текста
    function translite(str){
        var arr={'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ё':'yo', 'ж':'g', 'з':'z', 'и':'i', 'й':'y', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o', 'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'х':'ch', 'ц':'c', 'ч':'ch', 'ш':'sh', 'щ':'shh', 'ъ':'', 'ь':'', 'ы':'y', 'э':'e', 'ю':'yu', 'я':'ya',
            'А':'A', 'Б':'B', 'В':'V', 'Г':'G', 'Д':'D', 'Е':'E', 'Ё':'YO', 'Ж':'G', 'З':'Z', 'И':'I', 'Й':'Y', 'К':'K', 'Л':'L', 'М':'M', 'Н':'N', 'О':'O', 'П':'P', 'Р':'R', 'С':'S', 'Т':'T', 'У':'U', 'Ф':'F', 'Х':'CH', 'Ц':'C', 'Ч':'CH', 'Ш':'SH', 'Щ':'SHH', 'Ъ':'', 'Ь':'', 'Ы':'y', 'Ю':'YU', 'Я':'YA', 'Э':'E',
            '#':'', ' ':'-'};
        var replacer=function(a){return arr[a] !== void 0 ? arr[a]: a};
        return str.replace(/./g,replacer);
    }

    $(document).on('click', '.translits_href',function(){
        var title = $(this).parent().parent().prev().find('input').val();
        var url_trans = translite(title);
        url_trans = url_trans.toLowerCase();
        $(this).parent().parent().next().find('input').val(url_trans);
        return false;
    });

});