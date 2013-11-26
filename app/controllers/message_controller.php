<?php
class MessageController extends \Theogony\ControllerBase
{
	public function __construct() {
		parent::__construct();
		$this->_mixinGlobalLayout();
	}

	public function index(&$_)
	{
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

		$_->replies = $db->from('replies')->where([
			'thread_id' => $_->thread['id']
		])->run();

		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');

		if ($_SESSION['refresh-list'] == true) {
			unset($_SESSION['refresh-list']);
			header('Pjax-Container: main');
			$this->_mixinGlobalLayout(false);
			$this->_forceLayout();
		}
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
		if (count($board) == 0 || SessionHelper::getPerm() < $board[0]['perm']) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');

		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!isset($_POST['title']) || trim($_POST['title']) === "") {
				$_->status = -1;
				$_->error['title'] = 'Title must be entered.';
			}
			if (!isset($_POST['content']) || trim($_POST['content']) === "") {
				$_->status = -1;
				$_->error['content'] = 'Content must be entered.';
			}
			if ($_->status != 0)
				return;

			$res = $db->insert('threads')->value([
				'board_id' => $board[0]['id'],
				'account_id' => SessionHelper::getUser()['id'],
				'title' => htmlspecialchars(trim($_POST['title'])),
				'content' => trim($_POST['content'])
			])->run();

			$_SESSION['refresh-list'] = true;
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
				$_->referral = 'board-' . $_->name . '/message-' . $res['id'];
			} else {
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name . '/message-' . $res['id']);
				@exit();
			}
		}		
	}

	public function edit(&$_)
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
		if (count($board) == 0 || SessionHelper::getPerm() < $board[0]['perm']) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}

		$thread = $db->from('threads')->where([
			'id' => $_->option['msg']
		])->limit(1)->run();
		if (count($thread) == 0 || (SessionHelper::getUser()['id'] != $thread[0]['account_id'] && SessionHelper::getPerm() < 2)) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: board-' . $_->name);
			else
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
			@exit();
		}
		$_->thread = $thread[0];
		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');

		$_->author = $db->from('accounts')->where([
			'id' => $_->thread['account_id']
		])->limit(1)->run()[0];
		$_->content = isset($_POST['content']) ? $_POST['content'] : $_->thread['content'];

		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!isset($_POST['content']) || trim($_POST['content']) === "") {
				$_->status = -1;
				$_->error['content'] = 'Content must be entered.';
				return;
			}

			$res = $db->update('threads')->value([
				'content' => trim($_POST['content'])
			])->where([
				'id' => $_->thread['id']
			])->run();

			$_SESSION['refresh-list'] = true;
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
				$_->referral = 'board-' . $_->name . '/message-' . $_->thread['id'];
			} else {
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name . '/message-' . $_->thread['id']);
				@exit();
			}
		}		
	}

	public function delete_(&$_)
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
		if (count($board) == 0 || SessionHelper::getPerm() < $board[0]['perm']) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}

		$thread = $db->from('threads')->where([
			'id' => $_->option['msg']
		])->limit(1)->run();
		if (count($thread) == 0 || (SessionHelper::getUser()['id'] != $thread[0]['account_id'] && SessionHelper::getPerm() < 2)) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: board-' . $_->name);
			else
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
			@exit();
		}
		$_->thread = $thread[0];

		$res = $db->update('threads')->value([
			'deleted' => 1
		])->where([
			'id' => $_->thread['id']
		])->run();

		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
			header('Pjax-Location: board-' . $_->name);
		} else {
			header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
		}
		@exit();
	}

	public function reply(&$_)
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
		if (count($board) == 0 || SessionHelper::getPerm() < $board[0]['perm']) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: .');
			else
				header('Location: ' . $config->site->baseurl);
			@exit();
		}

		$thread = $db->from('threads')->where([
			'id' => $_->option['msg']
		])->limit(1)->run();
		if (count($thread) == 0 || (SessionHelper::getUser()['id'] != $thread[0]['account_id'] && SessionHelper::getPerm() < 2)) {
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
				header('Pjax-Location: board-' . $_->name);
			else
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name);
			@exit();
		}
		$_->thread = $thread[0];

		if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true')
			header('Pjax-Container: msg-' . $_->name . '-container');

		$_->status = 0;
		$_->error = array();
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!isset($_POST['content']) || trim($_POST['content']) === "") {
				$_->status = -1;
				$_->error['content'] = 'Content must be entered.';
				return;
			}

			$res = $db->insert('replies')->value([
				'thread_id' => $_->thread['id'],
				'account_id' => SessionHelper::getUser()['id'],
				'content' => trim($_POST['content'])
			])->run();

			$_SESSION['refresh-list'] = true;
			if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
				$_->referral = 'board-' . $_->name . '/message-' . $_->thread['id'];
			} else {
				header('Location: ' . $config->site->baseurl . 'board-' . $_->name . '/message-' . $_->thread['id']);
				@exit();
			}
		}	
	}
}
?>
