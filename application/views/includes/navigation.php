<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav-divider pull-right">
            <li class="user" style="color:#eaeaea;">Hello, <?= $_SESSION['user-fname']; ?>
                | <?= anchor('authenticate/logout', 'Logout',array('tabindex' => '8')); ?></li>

        </ul>
            <heading style="color:#eaeaea;font-size:2.5em;"><?= APP_NAME ?></heading>

    </div>
</div>        <!-- #header ends -->