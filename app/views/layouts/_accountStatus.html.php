<div id="accountStatus" class="pure-g">
<?php if (SessionHelper::getUser()): ?>
	<div class="pure-u"><img class="avatar" src="http://www.gravatar.com/avatar/<?= md5(strtolower(SessionHelper::getUser()['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" /></div>
	<div class="pure-u">
		<h4 class="account-nick"><?= SessionHelper::getUser()['username']?></h4>
		<h5 class="account-level">Lv. <?= SessionHelper::getUser()['perm'] ?></h5>
		<a href="account/logout" class="pure-button pure-button-small pure-button-primary" data-pjax>Logout</a>
	</div>
<?php else: ?>
	<div class="pure-u"><img class="avatar" src="http://placehold.it/64.png" alt="" /></div>
	<div class="pure-u">
		<h4 class="account-nick">Guest</h4>
		<h5 class="account-level">Lv. ???</h5>
		<a href="account/login" class="pure-button pure-button-small pure-button-primary" data-pjax>Login</a>
	</div>
<?php endif; ?>
</div>
