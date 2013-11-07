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
</head>
<body>
	<div id="layout" class="pure-g-r">
		<div id="nav" class="pure-u">
			<div class="nav-inner">
				<?= $this->import("accountStatus") ?>
				<?= $this->import("navMenu") ?>
			</div>
		</div>
		<div id="list" class="pure-u-1">
			<div class="pure-g msg-item msg-item-selected">
				<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Author</h5>
					<h4 class="msg-title">Title</h4>
					<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<div class="pure-g msg-reply">
						<div class="pure-g msg-item">
							<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
							<div class="pure-u-3-4">
								<h5 class="msg-author">Author</h5>
								<h4 class="msg-title">Title</h4>
								<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pure-g msg-item msg-item-unread">
				<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Author</h5>
					<h4 class="msg-title">Title</h4>
					<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
			</div>
			<div class="pure-g msg-item msg-item-unread">
				<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Author</h5>
					<h4 class="msg-title">Title</h4>
					<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<div class="pure-g msg-reply">
						<div class="pure-g msg-item">
							<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
							<div class="pure-u-3-4">
								<h5 class="msg-author">Author</h5>
								<h4 class="msg-title">Title</h4>
								<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pure-g msg-item">
				<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
				<div class="pure-u-4-5">
					<h5 class="msg-author">Author</h5>
					<h4 class="msg-title">Title</h4>
					<p class="msg-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
			</div>
		</div>
		<div id="main" class="pure-u-1">
			<div class="msg-detail">
				<div class="msg-detail-control">
					<a href="#" class="pure-button pure-button-sketch">Reply</a>
					<a href="#" class="pure-button pure-button-sketch">Edit</a>
					<a href="#" class="pure-button pure-button-sketch">Delete</a>
				</div>
				<div class="msg-detail-header pure-g">
					<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
					<div class="pure-u-1 msg-detail-header-content">
						<h1 class="msg-detail-title">Title</h1>
						<p class="msg-detail-subtitle">From <a href="#">Author</a> at <span>3:56pm, April 1, 2013</span></p>
					</div>
				</div>
				<div class="msg-detail-body">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<p>Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="msg-detail-reply-box pure-u-1">
					<div class="msg-detail-reply">
						<div class="msg-detail-header pure-g">
							<div class="pure-u"><img src="http://placehold.it/64" alt="" class="avatar" /></div>
							<div class="pure-u-1 msg-detail-header-content">
								<h1 class="msg-detail-title">Title</h1>
								<p class="msg-detail-subtitle">From <a href="#">Author</a> at <span>3:56pm, April 1, 2013</span></p>
							</div>
						</div>
						<div class="msg-detail-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							<p>Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
