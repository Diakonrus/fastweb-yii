<div class="sidebar-catalog">
	<div class="sidebar-header">
		<a href="/catalog/">Каталог</a>
	</div>
	<ul class="list-unstyled">
		<?=$ret?>
	</ul>
</div>

<script>
$(function() {
	$('.sidebar-catalog .div_arrow').click(function() {
		var idx = $(this).attr('idx');
		$('.parent_lmcontainer_'+idx).toggle();
		if ($('.parent_lmcontainer_'+idx).css('display') != 'none')
		{
			$(this).addClass('down');
		}
		else{
			$(this).removeClass('down');
		}
	});

/*
	$(".sidebar-catalog .div_arrow").mouseenter(function() {
		$(this).click();
	});
*/
});
</script>
