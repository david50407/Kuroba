<?php
class Account extends \Theogony\ModelBase
{
	public static $columns = array(
		'id' => 'number',
		'username' => 'string',
		'password' => 'string',
		'email' => 'string',
		'perm' => 'number',
		'created_at' => 'time',
		'updated_at' => 'time'
	);

	private static $salt = "0ef6";

	public static function generate_password($pass) {
		return sha1(md5($pass) . '$salt$' . self::$salt);
	}
}
?>
