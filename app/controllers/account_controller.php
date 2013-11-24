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
			if (!isset($_POST['rule'])) {
				$_->status = -1;
				$_->error['rule'] = 'You need a slime to register for you.';
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
				$_->error['$'] = 'Username or email has been used, or you may want to <a href=\"account/login\" data-pjax=\"login\">login</a>.';
			}
			
			if ($_->status != 0) return;

			// processing register
			$res = $db->insert("accounts")->value([
				'username' => $_POST['username'],
				'password' => Account::generate_password($_POST['password']),
				'email' => $_POST['email']
			])->run();

			$_SESSION['user_id'] = $res['id'];
			$_->referral = 'account/active';

		} // if (isset($_POST['username']))
	}
	public function active(&$_) {
		$jump = true;
		$config = \Theogony\ConfigCore::getInstance();
		if (isset($_SESSION['user_id'])) {
			$db = \Theogony\ConfigCore::getInstance()->database;
			$account = $db->from("accounts")->where([
				'id' => $_SESSION['user_id']
			])->run();
			if (count($account) > 0) {
				$account = $account[0];
				if ($account['perm'] == 0) { // user_or_above
					$ticket = $db->from("tickets")->where([
						'account_id' => $_SESSION['user_id']
					])->limit(1)->desc('id')->run();

					if (count($ticket) == 0 || strtotime($ticket[0]['expire_on']) - time() < 0) { // send a new one
						$token = sha1($account['username'] . '$' . md5(time()));
						$ticket = $db->insert('tickets')->value([
							'account_id' => $_SESSION['user_id'],
							'token' => $token,
							'expire_on' => date('Y-m-d H:i:s', time() + 60 * 60)
						])->run();
						$mail = MailHelper::send([$account['email'] => $account['email']],
							"[Kurōbā] Confirm your Kurōbā account", 
<<<__HTML__
<html>
	<body>
		<div style='font-family: "LucidaGrande" , "Lucida Sans Unicode", "Lucida Sans", Verdana, Tahoma, sans-serif; margin: 0; padding: 30px 20px; font-size: 13px; line-height: 1; color: #000; background-color: #eee;'>
			<p style='font-weight: bold;'>Hi there!</p>
			<p>We have received a request to active your account <strong>{$account['username']}</strong>. Confirm that you wish to active this account by clicking the link below (or paste it into your browser if that doesn't work). This step is to ensure that your identity is not stolen by others.</p>
			<p><a href='{$config->site->baseurl}account/active/{$token}'>{$config->site->baseurl}account/active/{$token}</a></p>
			<p>If you did not make this request yourself, just ignore this message.</p>
			<p>Have a nice day,<br />Kurōbā.</p>
			<p>This e-mail was sent by a user triggered event and thus can't really be unsubscribed from.<br />If you keep getting these message and don't want to, please contact <a href='mailto:kuroba@davy.tw'>customer support</a>.</p>
		</div>
	</body>
</html>
__HTML__
						);
						if ($mail)
							$jump = false;
					}
				}
			}
		}
		if ($jump) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: account/login');
			else
				header('Location: ' . $config->site->baseurl . 'account/login');
			@exit();
		}
	}
}
?>
