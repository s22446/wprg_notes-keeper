<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $title ?>
        </title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

        <?= $this->Html->meta("meta_token", $this->request->getAttribute("csrfToken")) ?>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css(['notes', 'normalize.min', 'milligram.min']) ?>
        <?= $this->Html->script(['jquery-3.6.0.min', 'notes-helper', 'notes']) ?>
    </head>
    <body>
        <div class="main-container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </body>
</html>
