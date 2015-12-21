$(document).ready(function(){

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
        var arr={'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ж':'g', 'з':'z', 'и':'i', 'й':'y', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o', 'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'ы':'i', 'э':'e', 'А':'A', 'Б':'B', 'В':'V', 'Г':'G', 'Д':'D', 'Е':'E', 'Ж':'G', 'З':'Z', 'И':'I', 'Й':'Y', 'К':'K', 'Л':'L', 'М':'M', 'Н':'N', 'О':'O', 'П':'P', 'Р':'R', 'С':'S', 'Т':'T', 'У':'U', 'Ф':'F', 'Ы':'I', 'Э':'E', 'ё':'yo', 'х':'h', 'ц':'ts', 'ч':'ch', 'ш':'sh', 'щ':'shch', 'ъ':'l', 'ь':'l', 'ю':'yu', 'я':'ya', 'Ё':'YO', 'Х':'H', 'Ц':'TS', 'Ч':'CH', 'Ш':'SH', 'Щ':'SHCH', 'Ъ':'', 'Ь':'','Ю':'YU', 'Я':'YA', '\\':'-', ' ':'-', ':':'-', '(':'-', ')':'-'};
        var replacer=function(a){return arr[a]||a};
        return str.replace(/[А-яёЁ:)(/\\ ]/g,replacer);
    }

    $("#Pages_title").keyup(function(){
        $("#Pages_url").val(translite($(this).val()));
    });

    $("#Pages_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#NewsGroup_name").keyup(function(){
        $("#NewsGroup_url").val(translite($(this).val()));
    });

    $("#NewsGroup_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#PhotoRubrics_name").keyup(function(){
        $("#PhotoRubrics_url").val(translite($(this).val()));
    });

    $("#PhotoRubrics_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#SaleGroup_name").keyup(function(){
        $("#SaleGroup_url").val(translite($(this).val()));
    });

    $("#SaleGroup_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#FaqRubrics_name").keyup(function(){
        $("#FaqRubrics_url").val(translite($(this).val()));
    });

    $("#FaqRubrics_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#CatalogRubrics_name").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogRubrics_url").val(translite(str));
    });

    $("#CatalogRubrics_url").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogRubrics_url").val(translite(str));
    });

    $("#WarehouseRubrics_name").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#WarehouseRubrics_url").val(translite(str));
    });
    $("#WarehouseRubrics_url").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#WarehouseRubrics_url").val(translite(str));
    });

    $("#CatalogtransmissionRubrics_name").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogtransmissionRubrics_url").val(translite(str));
    });
    $("#CatalogtransmissionRubrics_url").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogtransmissionRubrics_url").val(translite(str));
    });

    $("#CatalogengineRubrics_name").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogengineRubrics_url").val(translite(str));
    });
    $("#CatalogengineRubrics_url").keyup(function(){
        var str = $(this).val();
        str = str.toLowerCase();
        $("#CatalogengineRubrics_url").val(translite(str));
    });

    $("#BeforeAfterRubrics_name").keyup(function(){
        $("#BeforeAfterRubrics_url").val(translite($(this).val()));
    });

    $("#BeforeAfterRubrics_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#PressGroup_name").keyup(function(){
        $("#PressGroup_url").val(translite($(this).val()));
    });

    $("#PressGroup_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });

    $("#BanersRubrics_name").keyup(function(){
        $("#BanersRubrics_url").val(translite($(this).val()));
    });

    $("#BanersRubrics_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });




    $("#DoctorRubrics_name").keyup(function(){
        $("#DoctorRubrics_url").val(translite($(this).val()));
    });

    $("#DoctorRubrics_url").keyup(function(){
        $(this).val(translite($(this).val()));
    });




});