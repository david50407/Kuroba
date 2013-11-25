<div id="container-active" class="pure-g-r container-1" data-cache>
	<!-- active -->
	<div class="pure-u-1 container-content">
		<div class="pure-g active-container">
			<div class="pure-u-1-2">
				<div class="active-slogan">
					<h2>Active your <?= $config->site->title ?> account now.</h2>
					We have sent you a activation requset to your e-mail.
				</div>
			</div>
			<div class="pure-u-1-2">
				<div class="active-jump">
<?php if ($_->status == 1): ?>
					<h4>You have activated your account!<br />Enjoy your <?= $config->site->title ?> life now.</h4>
					<a class="pure-button pure-button-primary" href="." data-pjax>Go surfing now</a>
<?php else: ?>
<?php 	if ($_->status == -1): ?>
					<span class="form-notice-global show"><?= $_->error['$'] ?></span>
<?php 	else: ?>
					<span class="form-notice-global"></span>
<?php 	endif; ?>
					<h4>We guess your email provider's login page is here</h4>
					<a class="pure-button pure-button-primary" target="_blank" href="http://<?= $_->jump ?>">Go to inbox</a>
					<p><i><?= $_->jump ?></i></p>
<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
