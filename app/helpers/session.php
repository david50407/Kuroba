<?php

class SessionHelper {
	static private $account = null;

	static public function loginUser($account)
	{
		header('Pjax-Session-Changed: true');
		$_SESSION['user_id'] = $account['id'];
		self::$account = $account;
	}

	static public function logoutUser()
	{
		header('Pjax-Session-Changed: true');
		unset($_SESSION['user_id']);
		self::$account = false;
	}

	static public function getUser()
	{
		if (self::$account === null) {
			if (isset($_SESSION['user_id'])) {
				$db = \Theogony\ConfigCore::getInstance()->database;
				$account = $db->from('accounts')->where([
					'id' => $_SESSION['user_id']
				])->limit(1)->run();
				if (count($account) == 1) {
					self::$account = $account[0];
					return self::$account;
				}
				unset($_SESSION['user_id']);
			}
			$account = false;
			return false;
		}
		return self::$account;
	}

	static public function getPerm()
	{
		return self::getUser() ? self::getUser()['perm'] : 0;
	}
}

?>
