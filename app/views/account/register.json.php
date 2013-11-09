{
	status: "<?= $_->status ?>",
	error: [
<?php foreach ($_->error as $e): ?>
		{
			target: "<?= $e['target'] ?>",
			msg: "<?= $e['msg'] ?>"
		},
<?php endforeach; ?>
	]
}
