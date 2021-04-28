<?php

use app\core\table\Table;

use app\models\DbUser;

$this->title = 'Users';

?>

<div class="col-md-6 offset-md-3">
    <h1 class="text-center mb-4">Users</h1>
    <?php if (!empty($users)): ?>
        <div class="d-flex justify-content-center mb-4">
            <a class="btn btn-primary<?= $index <= 0 ? ' disabled' : '' ?>" href="/users?p=<?= $index - 1; ?>" role="button"><i class="bi-arrow-left"></i></a>
            <p class="lead align-self-center mx-4 mb-0">Page <?= $index + 1; ?> of <?= $pageCount; ?></p>
            <a class="btn btn-primary<?= $rowsLeft <= 0 ? ' disabled' : '' ?>" href="/users?p=<?= $index + 1; ?>" role="button"><i class="bi-arrow-right"></i></a>
        </div>
        <?php Table::print(['#', 'Username', 'E-mail address', 'Account status', 'Registered at'], DbUser::class, $users); ?>
    <?php else: ?>
        <p class="lead text-center">No users found.</p>
    <?php endif; ?>
</div>