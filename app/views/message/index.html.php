<div class="msg-detail" id="msg-<?= $_->name ?>-<?= $_->thread['id']?>">
	<div class="msg-detail-control">
<?php if (SessionHelper::getUser()): ?>
<?php 	if (SessionHelper::getUser()['perm'] >= 2 || SessionHelper::getUser()['id'] == $_->thread['account_id']): ?>
		<a href="board-<?= $_->name ?>/message-<?= $_->thread['id'] ?>/edit" class="pure-button pure-button-sketch" data-pjax>Edit</a>
		<a href="board-<?= $_->name ?>/message-<?= $_->thread['id'] ?>/delete" class="pure-button pure-button-sketch" data-twice="pure-button-sketch|pure-button-error"><span class="button-twice-first">Delete</span><span class="button-twice-second">Really?</span></a>
<?php 	endif; ?>
<?php 	if (SessionHelper::getUser()['perm'] > 0 ): ?>
		<a href="board-<?= $_->name ?>/message-<?= $_->thread['id'] ?>/reply" class="pure-button pure-button-sketch" data-pjax>Reply</a>
<?php 	endif; ?>
<?php endif; ?>
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
		<?= nl2br(htmlspecialchars($_->thread['content'])) ?>
	</div>
	<div class="msg-detail-reply-box pure-u-1">
<?php foreach($_->replies as $reply): ?>
<?php 	$author = $config->database->from('accounts')->where(['id' => $reply['account_id']])->limit(1)->run()[0]; ?>
		<div class="msg-detail-reply">
			<div class="msg-detail-toolbar">
				<a class="pure-button pure-button-sketch" href="board-<?= $_->name ?>/message-<?= $_->thread['id'] ?>/reply-<?= $reply['id'] ?>/delete" data-twice="pure-button-sketch|pure-button-error" >
					<span class="button-twice-first"><i class="icon-remove"></i></span>
					<span class="button-twice-second"><i class="icon-ok"></i></span>
				</a><br />
				<a class="pure-button pure-button-sketch" href="board-<?= $_->name ?>/message-<?= $_->thread['id'] ?>/reply-<?= $reply['id'] ?>/edit" data-pjax>
					<i class="icon-pencil"></i>
				</a>
			</div>
			<div class="msg-detail-header pure-g">
				<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
				<div class="pure-u-1 msg-detail-header-content">
					<h1 class="msg-detail-title">Re: <?= $_->thread['title'] ?></h1>
					<p class="msg-detail-subtitle">From <a href="mailto:<?= $author['email'] ?>" target="_blank"><?= $author['username'] ?></a> at <span><?= date("g:ia, F j, Y", strtotime($reply['created_at'])) ?></span></p>
				</div>
			</div>
			<div class="msg-detail-body">
				<?= nl2br(htmlspecialchars($reply['content'])) ?>
			</div>
		</div>
<?php endforeach; ?>
	</div>
</div>
