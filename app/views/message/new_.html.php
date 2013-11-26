<div class="msg-detail" id="msg-<?= $_->name ?>-new">
	<form action="board-<?= $_->name?>/message-new" method="post" class="msg-form" data-pjax>
	<div class="msg-detail-control">
<?php if (isset($_->error['$'])): ?>
		<span class="form-notice-global show"><?= $_->error['$'] ?></span>
<?php else: ?>
		<span class="form-notice-global"></span>
<?php endif; ?>
		<button type="submit" class="pure-button pure-button-primary">Post</button>
	</div>
	<div class="msg-detail-header pure-g">
		<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower(SessionHelper::getUser()['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
		<div class="pure-u-1 msg-detail-header-content">
			<h1 class="msg-detail-title">
				<input type="text" name="title" placeholder="Title" value="<?= $_POST['title'] ?>" />
<?php if (isset($_->error['title'])): ?>
				<span data-notice="title" class="form-notice show">!<span class="form-notice-tip"><?= $_->error['title'] ?></span></span>
<?php else: ?>
				<span data-notice="title" class="form-notice">!<span class="form-notice-tip"></span></span>
<?php endif; ?>
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
	</form>
</div>
