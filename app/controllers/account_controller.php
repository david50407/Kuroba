<?php
class AccountController extends \Theogony\ControllerBase
{
	public function index(&$_) {}

	public function login(&$_) {}
	public function register(&$_) {
		// registing: POST
		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			// check if empty
			if (!isset($_POST['username']) || trim($_POST['username']) === "") {
				$_->status = -1;
				$_->error['username'] = 'Username must be entered.';
			}
			if (!isset($_POST['password']) || trim($_POST['password']) === "") {
				$_->status = -1;
				$_->error['password'] = 'Password must be entered.';
			}
			if (!isset($_POST['password2']) || trim($_POST['password2']) === "") {
				$_->status = -1;
				$_->error['password2'] = 'Password must be confirmed.';
			}
			if (!isset($_POST['email']) || trim($_POST['email']) === "") {
				$_->status = -1;
				$_->error['email'] = 'E-mail address must be entered.';
			}

			// check if password not confirmed
			if (!isset($_->error['password']) and !isset($_->error['password2']))
				if (trim($_POST['password']) != trim($_POST['password2'])) {
					$_->status = -1;
					$_->error['password2'] = 'Twice password must be the same.';
				}
				
			// check if email is invalid
			if (!isset($_->error['email']))
				if (!preg_match("/^(([\w-]+\.)+[\w-]+|([a-zA-Z]{1}|[\w-]{2,}))" .
							"@((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\." .
							"([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|" .
							"([a-zA-Z]+[\w-]+\.)+[a-zA-Z]{2,4})$/",
						trim($_POST['email']))) {
					$_->status = -1;
					$_->error['email'] = 'Email must be valid.';
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
				$_->error['$'] = 'Username or email has been used, or you may want to <a href="account/login" data-pjax="login">login</a>.';
			}
			return;
		} // if (isset($_POST['username']))
	}
}
?>
