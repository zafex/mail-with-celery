<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * see tasks.py
 */
class TaskPassenger extends Viloveul\Transport\Passenger
{
    public function handle(): void
    {
        // celery argument
        $this->setArguments([
            $_POST['email'],
            $_POST['message'],
        ]);
    }

    public function point(): string
    {
        // queue name
        return 'celery';
    }

    public function task(): string
    {
        // celery task name
        return 'send.email';
    }
}

if (isset($_POST['email']) && isset($_POST['message'])) {
    $bus = new Viloveul\Transport\Bus();
    $bus->addConnection('amqp://localhost:5672//');
    $bus->process(new TaskPassenger());
    $bus->error()->clear();
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
