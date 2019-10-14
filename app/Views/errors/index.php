<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/global.css">

    <title>Soda Error</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="text-center">
                <img src="favicon.ico" height="128"/>
            </div>

            <div class="card bg-dark text-light shadow my-3">
                <div class="card-header font-weight-bolder">
                    [<?= $code ?>] <?= $class ?>
                </div>
                <div class="card-body font-weight-bold text-danger">
                    <p>
                        <?= $message ?>
                    </p>
                    <pre class="small overflow-auto text-white m-0" style="white-space: pre-wrap;"><?= $trace ?></pre>
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
