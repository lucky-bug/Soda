<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/global.css">

    <title>Tasks</title>
</head>
<body>

<?php
include VIEWS_DIR . 'layout/navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm my-3">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-hover m-0">
                        <thead>
                        <tr>
                            <th>
                                <a href="<?= url(
                                        '/tasks/index', [
                                            'sortBy' => 'name',
                                            'order' => !isset($_GET['order']) || $_GET['order'] == 'asc' ? 'desc' : 'asc',
                                        ], true) ?>">Name</a>
                            </th>
                            <th>
                                <a href="<?= url('/tasks/index', [
                                        'sortBy' => 'email',
                                    'order' => !isset($_GET['order']) || $_GET['order'] == 'asc' ? 'desc' : 'asc',
                                ], true) ?>">E-Mail</a>
                            </th>
                            <th>
                                Text
                            </th>
                            <th>
                                <a href="<?= url('/tasks/index', [
                                        'sortBy' => 'status',
                                    'order' => !isset($_GET['order']) || $_GET['order'] == 'asc' ? 'desc' : 'asc',
                                ], true) ?>">Status</a>
                            </th>
                            <?php
                            if (authenticated()) {
                                echo '<th>Operation</th>';
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($tasks as $task) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($task->getName()) ?></td>
                                    <td><?= htmlspecialchars($task->getEmail()) ?></td>
                                    <td><?= htmlspecialchars($task->getText()) ?></td>
                                    <td>
                                        <div><?= $task->getStatus() ? 'Finished' : 'Not Finished' ?></div>
                                        <div><?= $task->getEdited() ? 'Edited by Administrator' : '' ?></div>
                                    </td>
                                <?php if (authenticated()) { ?>
                                    <td>
                                        <form action="<?= url('/tasks/delete') ?>" method="post" id="deleleForm<?= $task->getId() ?>">
                                            <input type='hidden' name='id' value='<?= $task->getId() ?>'>
                                        </form>
                                        <input type="submit" class="btn btn-sm btn-danger" value="Delete" form="deleleForm<?= $task->getId() ?>"/>
                                        <a href="<?= url('/tasks/edit/' . $task->getId()) ?>" class="btn btn-sm btn-outline-success">
                                            Edit
                                        </a>
                                    </td>
                                <?php }
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="<?= url('tasks/index', ['page' => $page - 1], true) ?>" class="btn btn-light border <?= $hasPrevPage ? '' : 'disabled' ?>">Previous</a>
                            <a href="<?= url('tasks/index', ['page' => $page], true) ?>" class="btn btn-light border">
                                <?= $page ?>
                            </a>
                            <a href="<?= url('tasks/index', ['page' => $page + 1], true) ?>" class="btn btn-light border <?= $hasNextPage ? '' : 'disabled' ?>">Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/popper.js/popper.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/global.js"></script>

</body>
</html>
