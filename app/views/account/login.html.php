<div id="container-login" class="pure-g-r container-1" data-cache>
	<!-- login -->
	<div class="pure-u-1 container-content">
		<div class="pure-g login-container">
			<div class="pure-u-1-2">
				<div class="login-slogan">
					<h2>Login <?= $config->site->title ?>, posting message</h2>
					or now <a href="account/register" data-pjax="register" data-pjax-cache="true">Register</a>
				</div>
			</div>
			<div class="pure-u-1-2">
				<form class="pure-form pure-form-aligned login-form" action="account/login" method="post" data-pjax>
					<fieldset>
<?php if (isset($_->error['$'])): ?>
						<span class="form-notice-global show"><?= $_->error['$'] ?></span>
<?php else: ?>
						<span class="form-notice-global"></span>
<?php endif; ?>
						<div class="pure-control-group">
							<label for="name">Username</label>
							<input name="username" type="text" placeholder="Username" value="<?= $_POST['username'] ?>">
<?php if (isset($_->error['username'])): ?>
							<span data-notice="username" class="form-notice show">!<span class="form-notice-tip"><?= $_->error['username'] ?></span></span>
<?php else: ?>
							<span data-notice="username" class="form-notice">!<span class="form-notice-tip"></span></span>
<?php endif; ?>
						</div>	
						<div class="pure-control-group">
							<label for="password">Password</label>
							<input name="password" type="password" placeholder="Password">
<?php if (isset($_->error['password'])): ?>
							<span data-notice="password" class="form-notice show">!<span class="form-notice-tip"><?= $_->error['password'] ?></span></span>
<?php else: ?>
							<span data-notice="password" class="form-notice">!<span class="form-notice-tip"></span></span>
<?php endif; ?>
						</div>
						<div class="pure-controls">
							<label for="remember" class="pure-checkbox">
								<input name="remember" type="checkbox"> Remember me for 7 days.
							</label>
							<button type="submit" class="pure-button pure-button-primary">Login</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
