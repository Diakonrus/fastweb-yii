<?php foreach($list as $index => $item): ?>
<li><?php if($item['active']): ?><span><?php echo $item['name'] ?></span>
<?php else: ?><a href="<?php echo $item['url'] ?>"><?php echo $item['name'] ?></a><?php endif ?></li>
<?php endforeach; ?>