<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand">Soda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/tasks/index">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tasks/create">Create Task</a>
                </li>
            </ul>

            <?php if (!authenticated()) { ?>
                <form action="<?= url('/auth/login') ?>" method="post" class="form-inline my-2 my-lg-0 ml-auto">
                    <input class="form-control mr-sm-2" name="username" type="text" placeholder="Username" aria-label="Username">
                    <input class="form-control mr-sm-2" name="password" type="password" placeholder="Password" aria-label="Password">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Login</button>
                </form>
            <?php } else { ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            <?php }
            ?>
        </div>
    </div>
</nav>