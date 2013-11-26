<div id="container-msg-<?= $_->name ?>" class="pure-g-r container-2">
	<div class="pure-u-1 container-list">
<?php if (SessionHelper::getPrem() > 0): ?>
		<a href="board-<?= $_->name ?>/message-new" data-pjax>
			<div class="pure-g msg-item msg-item-post" data-msg="new">
				<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Guest</h5>
					<h4 class="msg-title">New message</h4>
					<p class="msg-content">Click here to leave new message...</p>
				</div>
			</div>
		</a>
<?php endif; ?>
<?php foreach($_->threads as $thread): ?>
<?php 	$author = $config->database->from('accounts')->where(['id' => $thread['account_id']])->limit(1)->run()[0]; ?>
		<a href="board-<?= $_->name ?>/message-<?= $thread['id'] ?>" data-pjax>
			<div class="pure-g msg-item">
				<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author"><?= $author['username'] ?></h5>
					<h4 class="msg-title"><?= $thread['title'] ?></h4>
					<p class="msg-content"><?= nl2br($thread['content']) ?></p>
					<div class="pure-g msg-reply">
						<div class="pure-g msg-item">
							<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
							<div class="pure-u-3-4">
								<h5 class="msg-author">Author</h5>
								<h4 class="msg-title">Title</h4>
								<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</a>
<?php endforeach; ?>
<!--
		<div class="pure-g msg-item msg-item-unread">
			<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
			<div class="pure-u-4-5">
				<h5 class="msg-author">Author</h5>
				<h4 class="msg-title">Title</h4>
				<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<div class="pure-g msg-reply">
					<div class="pure-g msg-item">
						<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
						<div class="pure-u-3-4">
							<h5 class="msg-author">Author</h5>
							<h4 class="msg-title">Title</h4>
							<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
-->
	</div>
	<div class="pure-u-1 container-content" id="msg-<?= $_->name ?>-container">
		<div class="msg-detail" id="msg-<?= $_->name ?>-none">
			<div class="msg-detail-none">
				<h2><i class="icon-hand-left"></i>&nbsp;&nbsp;Here for something interesting</h2>
			</div>
		</div>
	</div>
</div>
