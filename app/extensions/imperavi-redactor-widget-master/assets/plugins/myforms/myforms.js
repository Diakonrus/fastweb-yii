if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
	RedactorPlugins.myforms = function()
	{

        return {
            init: function ()
            {
                var button = this.button.add('advanced', 'Мои формы');
                this.button.setAwesome('advanced', 'icon-list-alt');

                var className =  $(button).parent().parent().attr('id')+'_mfrm';
                $(button).parent().parent().parent().find('textarea').addClass(className);
                var button = this.button.add(className, 'Мои формы');
                this.button.setAwesome(className, 'icon-list-alt');
                this.button.remove('advanced');



                this.button.addCallback(button, this.myforms.showForms);

            },
            showForms: function(button)
            {

                $.ajax({
                    type: 'POST',
                    url: '/admin/forms/creatingformrubrics/ajaxafrm',
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