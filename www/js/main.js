

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
				get_basket_count();
    		$('#frontend_alert span.text').html('Товар добавлен в корзину. Вы можете перейтив <a href="/basket"> корзину</a> для оформления заказа.');
    		//$('#frontend_alert').show();
    		//$('html,body').animate({scrollTop: $("#frontend_alert").offset().top},500);
    		$('html,body').animate({scrollTop: $("body").offset().top},500);
    		$('#shadowbox_container').show();
    		return true;
    });
    return false;

}

/*
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


*/

$(document).ready(function(){
	$(".fastorder").click(function () {
		$('#form_fastorder').show();
		var idx = $(this).attr('idx');
		var names = $(this).attr('names');
		var pic = $(this).attr('pic');

		$('input#fo_id_product').val(idx);
		$('#fo_product_title').html(names);
		$('#fo_product_pic').attr('src',pic);
		$('#fo_error_msg').html('');
		$('#fo_confirm_msg').html('');
		$('#modal_fastorder').modal('show');
	});
	$("#fo_submit").click(function () {
		var id_product = $('#fo_id_product').val();
		var fo_name = $('#fo_name').val();
		var fo_email = $('#fo_email').val();
		var fo_phone = $('#fo_phone').val();
			$.post(
				"/catalogfastorder/"+id_product,
				{
					name: fo_name,
					email: fo_email,
					phone: fo_phone
				},
				onAjaxSuccess
			);
			 
			function onAjaxSuccess(data)
			{
				$('#fo_error_msg').html('');
				$('#fo_confirm_msg').html('');
				var obj = jQuery.parseJSON(data);
				if (obj.error.length)
				{
					$('#fo_error_msg').html(obj.error);
				}
				else
				{
					$('#fo_confirm_msg').html('Ваш заказ отправлен. В ближайшее время мы с вами свяжемся.');
					$('#fo_name').val('');
					$('#fo_email').val('');
					$('#fo_phone').val('');
				}

			}
	});
	
  });

function get_basket_count(){
    $.get("/ajax.php", {
        basket: "getcount"
    }, function(data) {
        $('#basket_count').empty();
        $('#basket_count').html(data);
    });
    
    
    $.get("/content/basket/ajaxgettotal", {}, function(data) 
    {
        $('#basket_total').empty();
        $('#basket_total').html(data);
    });
}


function fn__recount_basket(){
  $.ajax({
      url: '/content/basket/ajaxrecount',
      type: "POST",
      dataType: "html",
      data: $("#basket_form").serialize(),
      success: function (response) {
          get_basket_count();
          $("#basketLists").load(document.location.href + " #basketLists tbody");
      }
  });
}







$(document).ready(function() {
	get_basket_count();

	$(document).on('click', '.basket_count_minus', function(){
		//$('#basketLists tbody').toggle();
		$('#basketLists tbody').fadeOut("3000");
		var count = $(this).parent().find('input.input_quantity').val();
		if (count>=2)
		{
			count = count-1;
		}
		$(this).parent().find('input.input_quantity').val(count);
		fn__recount_basket();
		$('#basketLists tbody').fadeIn("3000");
	});
	
	$(document).on('click', '.basket_count_plus', function(){
		$('#basketLists tbody').fadeOut("3000");
		var count = $(this).parent().find('input.input_quantity').val();
		count = parseInt(count)+Number(1);
		$(this).parent().find('input.input_quantity').val(count);
		fn__recount_basket();
		$('#basketLists tbody').fadeIn("3000");
	});
});
