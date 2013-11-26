<?php $perm = SessionHelper::getUser()['perm'] ? SessionHelper::getUser()['perm'] : 0; ?>
<div class="pure-menu pure-menu-open" id="navMenu">
	<ul>
<?php $db = \Theogony\ConfigCore::getInstance()->database; ?>
<?php $boards = $db->from('boards')->where(['perm' => [':<=', $perm]])->asc('id')->run(); ?>
<?php foreach ($boards as $board): ?>
		<li data-board="<?= $board["tiny"]?>" <?php if ($_->option['board'] == $board['tiny']): ?>class="pure-menu-selected"<?php endif; ?>>
			<a href="board-<?= $board['tiny']?>" data-pjax><?= $board['name'] ?></a>
		</li>
<?php endforeach; ?>
		<li class="pure-menu-heading">Admin</li>
		<li><a href="#">Setting</a></li>
		<li><a href="#">Report BUG</a></li>
	</ul>
</div>
