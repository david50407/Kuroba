<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title><?= $config->site->title; ?> -- Powered by Kuroba</title>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<base href="/guestbook/" />
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css" />
	<link rel="stylesheet" href="css/pure.ext.css" />
	<link rel="stylesheet" href="css/base.css" />
	<link rel="stylesheet" href="css/_msg.css" />
	<link rel="stylesheet" href="css/_login.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script async src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script async src="js/jquery.history.js"></script>
	<script async src="js/pjax.js"></script>
</head>
<body>
	<div id="layout" class="pure-g-r">
		<div id="nav" class="pure-u">
			<div class="nav-inner">
				<?= $this->import("accountStatus") ?>
				<?= $this->import("navMenu") ?>
			</div>
		</div>
		<div id="main" class="pure-u-1">
<?= $this->mixin(); ?>
		</div>
	</div>
</body>
</html>
