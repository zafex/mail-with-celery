<?php

if (isset($_POST['email']) && isset($_POST['message'])) {
	require __DIR__ . '/vendor/autoload.php';
	// open connection to rabbitmq-server
	$celery = new Celery('localhost', 'guest', 'guest', '/', 'celery', 'celery', 5673);
	// send task to rabbitmq-server
	$celery->PostTask('send.email', [$_POST['email'], $_POST['message']]);
	// done, sisanya terserah worker (in case : celery)
}

?>
<form method="POST">
<div>
<div>Email</div>
<input type="email" name="email">
</div>
<div>
<div>Message</div>
<textarea name="message"></textarea>
</div>
<button type="submit">Submit</button>
</form>
