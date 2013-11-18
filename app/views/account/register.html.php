<div id="container-register" class="pure-g-r container-1" data-cache>
	<!-- register -->
	<div class="pure-u-1 container-content">
		<div class="pure-g register-container">
			<div class="pure-u-1-2">
				<div class="register-slogan">
					<h2>Join <?= $config->site->title ?>, posting message</h2>
					Already has account? <a href="account/login" data-pjax="login" data-pjax-cache="true">Login</a>
				</div>
			</div>
			<div class="pure-u-1-2">
				<form class="pure-form pure-form-aligned register-form" action="account/register" method="post" data-pjax>
					<fieldset>
						<div class="pure-control-group">
							<label for="username">Username</label>
							<input id="username" name="username" type="text" placeholder="Username">
							<span data-notice="username" class="form-notice">!<span class="form-notice-tip"></span></span>
						</div>	
						<div class="pure-control-group">
							<label for="password">Password</label>
							<input id="password" name="password" type="password" placeholder="Password">
							<span data-notice="password" class="form-notice">!<span class="form-notice-tip"></span></span>
						</div>
						<div class="pure-control-group">
							<label for="password2"></label>
							<input id="password2" name="password2" type="password" placeholder="...again">
							<span data-notice="password2" class="form-notice">!<span class="form-notice-tip"></span></span>
						</div>
						<div class="pure-control-group">
							<label for="email">Email</label>
							<input id="email" name="email" type="text" placeholder="email">
							<span data-notice="email" class="form-notice">!<span class="form-notice-tip"></span></span>
						</div>	
						<div class="pure-controls">
							<label for="rule" class="pure-checkbox">
								<input id="rule" name="rule" type="checkbox"> I promise that I'm real creature, not a robot.
							</label>
							<button type="submit" class="pure-button pure-button-primary ladda-button" data-style="zoom-out">Register</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
