<?php
class BoardController extends \Theogony\ControllerBase
{
	public function sidebar(&$_) {}

	public function index(&$_)
	{
		$config = \Theogony\ConfigCore::getInstance();
		$db = $config->database;
		$_->name = $_->option['board'] ? $_->option['board'] : 'general';
		$_->page = $_->option['page'] ? $_->option['page'] : 0;
		$board = $db->from('boards')->where([
			'tiny' => $_->name
		])->limit(1)->run();
		if (count($board) == 0 || SessionHelper::getPerm() < $board[0]['perm']) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}

		$_->threads = $db->from('threads')->where([
			'board_id' => $board[0]['id'],
			'deleted'  => '0'
		])->desc('id')->limit(20)->offset(20 * $_->page)->run();
	}
}
?>
