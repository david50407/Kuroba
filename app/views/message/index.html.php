<div class="msg-detail" id="msg-<?= $_->name ?>-<?= $_->thread['id']?>">
	<div class="msg-detail-control">
<?php if (SessionHelper::getUser()): ?>
<?php 	if (SessionHelper::getUser()['perm'] >= 2 || SessionHelper::getUser()['id'] == $_->thread['account_id']): ?>
		<a href="#" class="pure-button pure-button-sketch">Edit</a>
		<a href="#" class="pure-button pure-button-sketch">Delete</a>
<?php 	endif; ?>
<?php endif; ?>
		<a href="#" class="pure-button pure-button-sketch">Reply</a>
	</div>
	<div class="msg-detail-header pure-g">
<?php $author = $config->database->from('accounts')->where(['id' => $_->thread['account_id']])->limit(1)->run()[0]; ?>
		<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
		<div class="pure-u-1 msg-detail-header-content">
			<h1 class="msg-detail-title"><?= $_->thread['title'] ?></h1>
			<p class="msg-detail-subtitle">From <a href="mailto:<?= $author['email'] ?>" target="_blank"><?= $author['username'] ?></a> at <span><?= date("g:ia, F j, Y", strtotime($_->thread['created_at'])) ?></span></p>
		</div>
	</div>
	<div class="msg-detail-body">
		<?= nl2br($_->thread['content']) ?>
	</div>
	<div class="msg-detail-reply-box pure-u-1">
		<div class="msg-detail-reply">
			<div class="msg-detail-header pure-g">
				<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
				<div class="pure-u-1 msg-detail-header-content">
					<h1 class="msg-detail-title">Title</h1>
					<p class="msg-detail-subtitle">From <a href="#">Author</a> at <span>3:56pm, April 1, 2013</span></p>
				</div>
			</div>
			<div class="msg-detail-body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<p>Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
		</div>
	</div>
</div>
