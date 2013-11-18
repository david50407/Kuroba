{
	"status": <?= $_->status ?>,
	"error": {
<?php foreach (array_keys($_->error) as $i => $k): ?>
		"<?= $k ?>": "<?= $_->error[$k] ?>"<?= $i == count($_->error) - 1 ? "" : "," ?> 
<?php endforeach; ?>
	}
}
