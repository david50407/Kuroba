<div class="msg-detail" id="msg-<?= $_->name ?>-new">
	<form action="board-<?= $_->name?>/message-<?= $_->thread['id'] ?>/reply" method="post" class="msg-form" data-pjax>
	<div class="msg-detail-control">
<?php if (isset($_->error['$'])): ?>
		<span class="form-notice-global show"><?= $_->error['$'] ?></span>
<?php else: ?>
		<span class="form-notice-global"></span>
<?php endif; ?>
		<button type="submit" class="pure-button pure-button-primary">Reply</button>
	</div>
	<div class="msg-detail-header pure-g">
		<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($_->author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
		<div class="pure-u-1 msg-detail-header-content">
			<h1 class="msg-detail-title"><?= $_->thread['title'] ?></h1>
			<p class="msg-detail-subtitle">From <a href="mailto:<?= $_->author['email'] ?>" target="_blank"><?= $_->author['username'] ?></a> at <span><?= date("g:ia, F j, Y", strtotime($_->thread['created_at'])) ?></span></p>
		</div>
	</div>
	<div class="msg-detail-body">
		<?= nl2br(htmlspecialchars($_->thread['content'])) ?>
	</div>
	<div class="msg-detail-reply-box pure-u-1">
		<div class="msg-detail-reply">
			<div class="msg-detail-header pure-g">
				<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower(SessionHelper::getUser()['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
				<div class="pure-u-1 msg-detail-header-content">
					<h1 class="msg-detail-title">Re: <?= $_->thread['title'] ?>
<?php if (isset($_->error['content'])): ?>
						<span data-notice="content" class="form-notice show">!<span class="form-notice-tip"><?= $_->error['content'] ?></span></span>
<?php else: ?>
						<span data-notice="content" class="form-notice">!<span class="form-notice-tip"></span></span>
<?php endif; ?>
					</h1>
					<p class="msg-detail-subtitle">From <a href="mailto:<?= SessionHelper::getUser()['email'] ?>" target="_blank"><?= SessionHelper::getUser()['username'] ?></a> at <span>now</span></p>
				</div>
			</div>
			<div class="msg-detail-body">
				<textarea name="content" class="autosize-textarea"><?= $_POST['content'] ?></textarea>
			</div>
		</div>
	</div>
	</form>
</div>
