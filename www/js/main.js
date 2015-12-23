

function SupposeInBasket(path, module, field, parent_id, element, mod, number, transaction, discount, add, curr) {
    $.post("/ajax.php", {
        m: "31",
        path: path,
        module: module,
        field: field,
        parent_id: parent_id,
        element: element,
        mod: mod,
        number: number,
        transaction: transaction,
        discount: discount,
        add: add,
        curr: curr
    }, function(data) {
        var bw = $('body').width();
        var bh = $(window).height();
        var bh2 = $(document).height();
        var dh = $(window).scrollTop();
        $('#bas_centered_box').css('top', bh / 2 + dh + 'px');
        $('#bas_centered_box').css('left', bw / 2 + 'px');
        $('#bas_shader').css('height', bh2);
        $('#basket_h').show();
        return false;
    });
    return false;
}

function ch1() {
    if (document.getElementById('position3').style.display != 'none') {
        document.getElementById('position3').style.display = 'none';
        document.getElementById('position1').style.display = 'block';
        document.getElementById('position2').style.display = 'block';
        document.getElementById('position4').style.display = 'none';
        document.getElementById('hiddiv').style.display = 'block';
    } else {
        document.getElementById('position3').style.display = 'block';
        document.getElementById('position1').style.display = 'none';
        document.getElementById('position2').style.display = 'none';
        document.getElementById('position4').style.display = 'block';
        document.getElementById('hiddiv').style.display = 'none';
    }
}

function chreg1() {
    if (document.getElementById('position3').style.display != 'none') {
        document.getElementById('position3').style.display = 'none';
        document.getElementById('position1').style.display = 'block';
        document.getElementById('position2').style.display = 'block';
        document.getElementById('position4').style.display = 'none';
        document.getElementById('loc_inv').style.display = 'block';
    } else {
        document.getElementById('position3').style.display = 'block';
        document.getElementById('position1').style.display = 'none';
        document.getElementById('position2').style.display = 'none';
        document.getElementById('position4').style.display = 'block';
        document.getElementById('loc_inv').style.display = 'none';
    }
}

function ChDelivery(id, tsena, summ) {
    $.get("/ajax.php", {
        m: "34",
        i: id,
        t: tsena,
        s: summ
    }, function(data) {
        document.getElementById('summ').innerHTML = data;
    });
}


function set_basket(basketurl) {
    $.get("/ajax.php", {
        m: "33",
        p: basketurl
    }, function(data) {
        document.getElementById('b1').innerHTML = data;
    });
}
$(document).ready(function() {});
jQuery(document).ready(function() {
    jQuery('.plus_li').click(function() {
        jQuery(this).prev().toggle();
        jQuery(this).toggleClass('plus_li_active');
    });
    jQuery('a.image-rel-10').click(function() {
        jQuery(this).next().toggle();
        jQuery(this).next().next().toggleClass('plus_li_active');
    });
});

function set_selection(selid, url) {
    $.get("/ajax.php", {
        m: "47",
        e: selid,
        u: url
    }, function(data) {});
}

function checkbox(inp) {
    if ($(inp).attr('class') == 'checkboxArea') {
        $(inp).removeClass('checkboxArea');
        $(inp).addClass('checkboxAreaChecked');
        $(inp).next().attr("checked", 'checked');
        $('.sr').show();
    } else {
        $(inp).removeClass('checkboxAreaChecked');
        $(inp).addClass('checkboxArea');
        $(inp).next().removeAttr("checked");
    }
}

function checkbox_2(inp_2) {
    $('#' + inp_2 + '').hide();
}

function get_basket_count(){
    $.get("/ajax.php", {
        basket: "getcount"
    }, function(data) {
        $('#basket_count').empty();
        $('#basket_count').html(data);
    });
}