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

<nav class="navbar navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand">Soda</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card my-3 shadow-sm">
                <div class="card-body">
                    <form action="/tasks/create" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" id="email" name="email" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <input type="text" id="text" name="text" class="form-control"/>
                        </div>
                        <hr/>
                        <div>
                            <input type="submit" value="Create Task" class="btn btn-block btn-primary"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm my-3">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover m-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-Mail</th>
                            <th>Text</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($tasks as $task) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($task->getName()) . '</td>';
                                echo '<td>' . htmlspecialchars($task->getEmail()) . '</td>';
                                echo '<td>' . htmlspecialchars($task->getText()) . '</td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="?page=<?= $page - 1 ?>" class="btn btn-light border">Previous</a>
                            <a href="?page=<?= $page ?>" class="btn btn-light border">
                                <?= $page ?>
                            </a>
                            <a href="?page=<?= $page + 1 ?>" class="btn btn-light border">Next</a>
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
