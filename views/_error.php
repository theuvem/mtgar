<?php

$this->title = 'Error';

?>

<div class="col-md-6 offset-md-3 text-center">
    <h1>Error <?= $exception->getCode(); ?></h1>
    <h3><?= $exception->getMessage(); ?></h3>
</div>