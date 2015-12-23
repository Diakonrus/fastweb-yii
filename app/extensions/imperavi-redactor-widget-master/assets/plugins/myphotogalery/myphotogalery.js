if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
	RedactorPlugins.myphotogalery = function()
	{

        return {
            init: function ()
            {
                var button = this.button.add('advanced', 'Фотогалерея');
                this.button.setAwesome('advanced', 'icon-camera');

                var className =  $(button).parent().parent().attr('id')+'_mphglry';
                $(button).parent().parent().parent().find('textarea').addClass(className);
                var button = this.button.add(className, 'Фотогалерея');
                this.button.setAwesome(className, 'icon-camera');
                this.button.remove('advanced');



                this.button.addCallback(button, this.myphotogalery.showGallery);

            },
            showGallery: function(button)
            {

                $.ajax({
                    type: 'POST',
                    url: '/admin/photo/photorubrics/ajaxalbom',
                    dataType: "html",
                    data: {request:button},
                    success: function(data){
                        var html = '<div style="position: absolute; z-index: 9999; top:0px; left:30%; margin-top:300px;">'+data+'</div>';
                        $('body').append(html);
                    }
                });


            }
        };


	};
})(jQuery);