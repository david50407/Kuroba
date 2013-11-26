<?php
class AccountController extends \Theogony\ControllerBase
{
	public function index(&$_) {}

	public function login(&$_) {
		$config = \Theogony\ConfigCore::getInstance();
		if (SessionHelper::getUser()) { // logined
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: ' . $config->site->baseurl);
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}
		// registing: POST
		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!isset($_POST['username']) || trim($_POST['username']) === "") {
				$_->status = -1;
				$_->error['username'] = 'Username must be entered.';
			}
			if (!isset($_POST['password']) ||      $_POST['password']  === "") {
				$_->status = -1;
				$_->error['password'] = 'Password must be entered.';
			}
			if ($_->status != 0) return;

			$db = \Theogony\ConfigCore::getInstance()->database;
			$res = $db->from("accounts")->where([
				'username' => trim($_POST['username'])
			])->limit(1)->run();

			if (count($res) == 0 || $res[0]['password'] != Account::generate_password($_POST['password'])) {
				$_->status = -1;
				$_->error['$'] = 'Username and password are not matched, or you may <a href=\"account/login\" data-pjax=\"login\">forgot password</a>.';
			}	
			if ($_->status != 0) return;

			SessionHelper::loginUser($res[0]);
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				$_->referral = '.';
			else {
				header('Location: ' . $config->site->baseurl);
				@exit();
			}
		}
	}
	public function register(&$_) {
		$config = \Theogony\ConfigCore::getInstance();
		if (SessionHelper::getUser()) { // logined
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: account/login');
			else
				header('Location: ' . $config->site->baseurl . 'account/login');
			@exit();
		}
		// registing: POST
		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!isset($_POST['username']) || trim($_POST['username']) === "") {
				$_->status = -1;
				$_->error['username'] = 'Username must be entered.';
			} elseif (!preg_match("/^[a-zA-Z]/", trim($_POST['username']))) {
				$_->status = -1;
				$_->error['username'] = 'Username must started from alphabets';
			} elseif (strlen(trim($_POST['username'])) < 5) {
				$_->status = -1;
				$_->error['username'] = 'Username must be at least 5 letters';
			} elseif (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]+$/", trim($_POST['username']))) {
				$_->status = -1;
				$_->error['username'] = 'Username must only have alphabets, numbers, and underline (_)';
			}
			if (!isset($_POST['password']) || $_POST['password'] === "") {
				$_->status = -1;
				$_->error['password'] = 'Password must be entered.';
			} elseif (strlen($_POST['password']) < 8) {
				$_->status = -1;
				$_->error['password'] = 'Password must be at least 8 letters';
			}
			if (!isset($_POST['password2']) || $_POST['password2'] === "") {
				$_->status = -1;
				$_->error['password2'] = 'Password must be confirmed.';
			}
			if (!isset($_POST['email']) || trim($_POST['email']) === "") {
				$_->status = -1;
				$_->error['email'] = 'E-mail address must be entered.';
			} elseif (!preg_match("/^(([\w-]+\.)+[\w-]+|([a-zA-Z]{1}|[\w-]{2,}))" .
						"@((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\." .
						"([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|" .
						"([a-zA-Z]+[\w-]+\.)+[a-zA-Z]{2,4})$/",
					trim($_POST['email']))) {
				$_->status = -1;
				$_->error['email'] = 'Email must be valid.';
			}
			if (!isset($_POST['rule'])) {
				$_->status = -1;
				$_->error['rule'] = 'You need a slime to register for you.';
			}

			// check if password not confirmed
			if (!isset($_->error['password']) and !isset($_->error['password2']))
				if ($_POST['password'] !== $_POST['password2']) {
					$_->status = -1;
					$_->error['password2'] = 'Twice password must be the same.';
				}
				
			// check if username or email repeats
			$db = \Theogony\ConfigCore::getInstance()->database;
			// $res = Account.where(...);
			$res = $db->from("accounts")->where([':or',
				'username' => $_POST['username'],
				'email' => $_POST['email']
			])->run();
			//if (!$res->empty()) // repeated
			if (count($res) > 0) {
				$_->status = -1;
				$_->error['$'] = 'Username or email has been used, or you may want to <a href=\"account/login\" data-pjax=\"login\">login</a>.';
			}
			
			if ($_->status != 0) return;

			// processing register
			$res = $db->insert("accounts")->value([
				'username' => $_POST['username'],
				'password' => Account::generate_password($_POST['password']),
				'email' => $_POST['email']
			])->run();

			SessionHelper::loginUser($res);
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				$_->referral = 'account/active';
			else {
				header('Location: ' . $config->site->baseurl . 'account/active');
				@exit();
			}

		} // if (isset($_POST['username']))
	}
	public function active(&$_) {
		$config = \Theogony\ConfigCore::getInstance();
		$db = $config->database;
		$_->status = 0;
		$_->error = [];
		if (SessionHelper::getUser()) { // logined
			$account = SessionHelper::getUser();
			if ($account['perm'] == 0) {
				$_->jump = preg_replace("/^[^@]+@(mail\.)?/", "mail.", $account['email']);
				if ($_->jump == "mail.gmail.com")
					$_->jump = "gmail.com";
				$ticket = $db->from("tickets")->where([
					'account_id' => $_SESSION['user_id']
				])->limit(1)->desc('id')->run();

				if (isset($_->option['id'])) { // activation
					if (count($ticket) == 0 || $ticket[0]['token'] != $_->option['id']) {
						$_->status = -1; // token not matched
						$_->error['$'] = "Invalid request. Maybe this is not your account?";
						return;
					}
					$_->updated = $db->update('accounts')->value([
						'perm' => 1 // user
					])->where([
						'id' => $_SESSION['user_id']
					])->run();
					$_->status = 1;
					$_->info = "Activated! Enjoy your {$config->site->title} life.";
					$account = $db->from('accounts')->where([
						'id' => $_SESSION['user_id']
					])->limit(1)->run();
					SessionHelper::loginUser($account);
				} elseif (count($ticket) == 0 || strtotime($ticket[0]['expire_on']) - time() < 0) { // send a new one
					$token = sha1($account['username'] . '$' . md5(time()));
					$ticket = $db->insert('tickets')->value([
						'account_id' => $_SESSION['user_id'],
						'token' => $token,
						'expire_on' => date('Y-m-d H:i:s', time() + 60 * 60)
					])->run();
					MailHelper::sendActivation($account['username'], $account['email'], $token);
					$_->status = -1;
					$_->error['$'] = "We just sent you a activation requset.";
				}
				return;
			}
			$_->status = 1;
			return;
		} else {
			if (isset($_->option['id'])) { // activation
				$ticket = $db->from("tickets")->where([
					'id' => $_->option['id']
				])->limit(1)->run();

				if (count($ticket) == 0) {
					$_->status = -1; // token not matched
					$_->error['$'] = "Invalid request.";
					return;
				}
				$_->updated = $db->update('accounts')->value([
					'perm' => 1 // user
				])->where([
					'id' => $_SESSION['user_id']
				])->run();
				$_->status = 1;
				return;
			}
		}
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Location: account/login');
		else
			header('Location: ' . $config->site->baseurl . 'account/login');
		@exit();
	}

	public function logout()
	{
		SessionHelper::logoutUser();
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Location: account/login');
		else
			header('Location: ' . \Theogony\ConfigCore::getInstance()->site->baseurl . 'account/login');
		@exit();
	}

	public function status()
	{
		if (!isset($_SERVER['HTTP_X_PJAX']) || $_SERVER['HTTP_X_PJAX'] !== 'true') {
			header('Location: ' . \Theogony\ConfigCore::getInstance()->site->baseurl);
			@exit();
		}
	}
}
?>
