<?php
class MessageController extends \Theogony\ControllerBase
{
	public function index(&$_)
	{
		$this->_mixinGlobalLayout();
		$config = \Theogony\ConfigCore::getInstance();
		$db = $config->database;
		$_->name = $_->option['board'];
		$_->page = $_->option['page'] ? $_->option['page'] : 0;
		$board = $db->from('boards')->where([
			'tiny' => $_->name
		])->limit(1)->run();
		if (count($board) == 0) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}

		$_->thread = $db->from('threads')->where([
			'id' => $_->option['msg']
		])->limit(1)->run();
		if (count($_->thread) == 0) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: board-' . $_->name);
			else
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
			@exit();
		}
		$_->thread = $_->thread[0];
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');
	}

	public function new_(&$_)
	{
		$config = \Theogony\ConfigCore::getInstance();
		$db = $config->database;
		$_->name = $_->option['board'];
		if (SessionHelper::getPerm() == 0) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: board-' . $_->name);
			else
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
			@exit();
		}

		$board = $db->from('boards')->where([
			'tiny' => $_->name
		])->limit(1)->run();
		if (count($board) == 0) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');
	}
}
?>
