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
				<form class="pure-form pure-form-aligned register-form" action="account/register" method="post">
					<fieldset>
						<div class="pure-control-group">
							<label for="username">Username</label>
							<input id="username" type="text" placeholder="Username">
						</div>	
						<div class="pure-control-group">
							<label for="password">Password</label>
							<input id="password" type="password" placeholder="Password">
						</div>
						<div class="pure-control-group">
							<label for="password2"></label>
							<input id="password2" type="password" placeholder="...again">
						</div>
						<div class="pure-control-group">
							<label for="email">Email</label>
							<input id="email" type="text" placeholder="email">
						</div>	
						<div class="pure-controls">
							<label for="rule" class="pure-checkbox">
								<input id="rule" type="checkbox"> I promise that I'm real person, not a robot.
							</label>
							<button type="submit" class="pure-button pure-button-primary">Login</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
