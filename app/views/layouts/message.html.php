<?php $threads = $config->database->from('threads')->where([
				'board_id' => $config->database->from('boards')->where([
					'tiny' => $_->name
				])->limit(1)->run()[0]['id'],
				'deleted' => '0'
			])->desc('id')->run();
?>
<div id="container-msg-<?= $_->name ?>" class="pure-g-r container-2">
	<div class="pure-u-1 container-list">
<?php if (SessionHelper::getPerm() > 0): ?>
		<a href="board-<?= $_->name ?>/message-new" data-pjax>
			<div class="pure-g msg-item msg-item-post<?= $_->option['action'] == 'new_' ? " msg-item-selected" : "" ?>" data-message="new">
				<div class="pure-u"><img src="http://placehold.it/64.png" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Guest</h5>
					<h4 class="msg-title">New message</h4>
					<p class="msg-content">Click here to leave new message...</p>
				</div>
			</div>
		</a>
<?php endif; ?>
<?php	foreach($threads as $thread): ?>
<?php 	$author = $config->database->from('accounts')->where(['id' => $thread['account_id']])->limit(1)->run()[0]; ?>
		<a href="board-<?= $_->name ?>/message-<?= $thread['id'] ?>" data-pjax>
			<div class="pure-g msg-item<?= $_->option['msg'] == $thread['id'] ? " msg-item-selected" : "" ?>" data-message="<?= $thread['id'] ?>">
				<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author"><?= $author['username'] ?></h5>
					<h4 class="msg-title"><?= $thread['title'] ?></h4>
					<p class="msg-content"><?= nl2br(htmlspecialchars($thread['content'])) ?></p>
					<div class="pure-g msg-reply">
						<div class="pure-u-1">
<?php 	$replies = $config->database->from('replies')->where([
					'thread_id' => $thread['id'],
					'deleted' => '0'
				])->desc('id')->run();
?>
<?php 	foreach($replies as $reply): ?>
<?php 		$author = $config->database->from('accounts')->where(['id' => $reply['account_id']])->limit(1)->run()[0]; ?>
							<div class="pure-g msg-item">
								<div class="pure-u"><img src="http://www.gravatar.com/avatar/<?= md5(strtolower($author['email'])) ?>?d=<?= urlencode("http://placehold.it/64.png") ?>&s=64" alt="" class="avatar" /></div>
								<div class="pure-u-3-4">
									<h5 class="msg-author"><?= $author['username'] ?></h5>
									<h4 class="msg-title">Re: <?= $thread['title'] ?></h4>
									<p class="msg-content"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
								</div>
							</div>
<?php 	endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</a>
<?php endforeach; ?>
	</div>
	<div class="pure-u-1 container-content" id="msg-<?= $_->name ?>-container">
<?= $this->mixin() ?>
	</div>
</div>
