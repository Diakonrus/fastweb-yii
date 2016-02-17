(function($, window, document) {
    $(function() {
        //select
        $(".click").on("click", function() {
            $('#giveReview').modal(
                "show"
            )
        })
        $( ".select-custom" ).selectpicker();
        //скроллбар
        $(".scrolled").mCustomScrollbar({
            theme: "news"
        });
        //Раскрытие групп в фильтре
        $(".slide-items").on("click", ".slide-trigger", function() {
            $(this).toggleClass("active");
            $(this).next(".slide-item").slideToggle();
        });
        //Слайдер цен в фильтре
        var $rangeBar = $(".range-bar");
        $rangeBar.each(function() {
            var $this = $(this),
                $rangeMeter = $this.find(".range-meter"),
                max = $this.attr("data-max"),
                suffix = "";
            if($this.attr("data-length")) {
                suffix = " м"
            }
            $this.find(".amountMax").val(max + suffix);
            $rangeMeter.slider({
                min: 0,
                max: max,
                range: true,
                values: [ 0, max ],
                slide: function( event, ui ) {
                    $this.find(".amountMin").val(ui.values[ 0 ] + suffix);
                    $this.find(".amountMax").val(ui.values[ 1 ] + suffix);
                }
            });
        });

        //Кнопки карусели
        $(".carousel-next").on("click", function() {
            $('.carousel').carousel("next");
            return false;
        });
        $(".carousel-prev").on("click", function() {
            $('.carousel').carousel("prev");
            return false;
        });
        //Не перезагружать страницу по клику на пустую ссылку
        $("body").on("click", "a[href='']", function() {
            return false;
        });
        //Увеличение количества товара
        //изменение количества товара
        $('.item-count-area').each(function(i, e)
        {
            var $e = $(e),
                $input = $e.find('.item-count'),
                $inc = $e.find('.item-count-inc'),
                $dec = $e.find('.item-count-dec');

            $inc.click(function(e)
            {
                var curValue = +$input.val();
                $input.val(curValue + 1);
            });
            $dec.click(function(e)
            {
                var curValue = +$input.val();
                $input.val(Math.max(curValue - 1, 1));
            });
        });
    })
}(window.jQuery, window, document));