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
				<form class="pure-form pure-form-aligned login-form">
					<fieldset>
						<div class="pure-control-group">
							<label for="name">Username</label>
							<input id="name" type="text" placeholder="Username">
						</div>	
						<div class="pure-control-group">
							<label for="password">Password</label>
							<input id="password" type="password" placeholder="Password">
						</div>
						<div class="pure-controls">
							<label for="remember" class="pure-checkbox">
								<input id="remember" type="checkbox"> Remember me for 7 days.
							</label>
							<button type="submit" class="pure-button pure-button-primary">Login</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
