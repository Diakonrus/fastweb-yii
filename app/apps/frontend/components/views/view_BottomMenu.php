<?php
/** @var $pages array */
/** @var $currentPageUri string */
?>
<div id="BottomMenuWrap">
	<!-- begin #BottomMenu  -->
	<ul class="menu" id="BottomMenu">
		<?php foreach ($pages as $id => $val): ?>

			<li>
				<a href="<?=$val['url'];?>" class="<?= trim($currentPageUri, '/') == trim($val['url'], '/') ? 'active' : '' ;?>"><?=$val['title'];?></a>
				<?php if (isset($val['children'])) { foreach ($val['children'] as $val_children){ ?>
					<ul>
						<li>
							<a href="<?=$val_children['url'];?>"><?=$val_children['title'];?></a>
						</li>
					</ul>
				<?php }} ?>
			</li>

		<?php endforeach; ?>
	</ul>
	<!-- end #BottomMenu  -->
</div>
