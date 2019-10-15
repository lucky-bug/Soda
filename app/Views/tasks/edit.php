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
        <div class="offset-md-3 col-md-6">
            <div class="card my-3 shadow-sm">
                <div class="card-body">
                    <form action="/tasks/edit/<?= $task->id ?>" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" disabled value="<?= $task->getName() ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" id="email" name="email" class="form-control" disabled value="<?= $task->getEmail() ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <input type="text" id="text" name="text" class="form-control" value="<?= $task->getText() ?>"/>
                            <?php
                            if (isset($errors['text'])) {
                                echo '<ul class="small text-danger">';
                                foreach ($errors['text'] as $error) {
                                    echo "<li>{$error}</li>";
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0" <?= $task->status ? 'selected' : '' ?>>Not Finished</option>
                                <option value="1" <?= $task->status ? 'selected' : '' ?>>Finished</option>
                            </select>
                            <?php
                            if (isset($errors['status'])) {
                                echo '<ul class="small text-danger">';
                                foreach ($errors['status'] as $error) {
                                    echo "<li>{$error}</li>";
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <hr/>
                        <div>
                            <input type="submit" value="Create Task" class="btn btn-block btn-primary"/>
                        </div>
                    </form>
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
