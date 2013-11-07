<?php
Theogony\ConfigCore::draw(function($config) {
	$config->database = new \Theogony\Database\Mysql(function(&$config) {
		$config->host = '127.0.0.1';
		$config->username = 'Kuroba';
		$config->password = 'kuro-ba-';
		$config->database = 'Kuroba';
	});

	$config->site = new ArrayObject();
	$config->site->title = 'Kurōbā';
});
?>
