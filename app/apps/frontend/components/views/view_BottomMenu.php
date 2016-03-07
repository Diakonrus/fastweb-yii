<div id="BottomMenuWrap">			
	<!-- begin #BottomMenu  -->
	<ul class="menu" id="BottomMenu">
		<?php foreach (Pages::getMenu(3) as $id => $val){ ?>

			<li>
				<a href="<?=$val['url'];?>" class="<?=(($curentPageID == $id)?('active;'):(''));?>  "  ><?=$val['title'];?></a>
				<?php if (isset($val['children'])) { foreach ($val['children'] as $val_children){ ?>
					<ul>
						<li>
							<a href="<?=$val_children['url'];?>"><?=$val_children['title'];?></a>
						</li>
					</ul>
				<?php }} ?>
			</li>

		<?php } ?>
	</ul>
	<!-- end #BottomMenu  -->
</div>
