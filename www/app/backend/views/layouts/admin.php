<?php
/** @var $user */
/** @var $userType */
/** @var $success */
/** @var $scripts */

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/lib/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/css/lib/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/lib/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="/css/lib/tui-calendar/tui-calendar.css">
    <link rel="stylesheet" href="/css/dashboard.css">

    <title><?php echo $title ?? 'Citas CSS' ?></title>
</head>

<body>
<header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 bg-primary" href="/">
        <img src="/media/logo.png" alt="" class="d-inline-block me-2" style="width: 60px; height: 60px">
        <span class="d-none d-sm-inline fw-bold">CAJA DE SEGURO SOCIAL</span>
        <span class="d-inline-block d-sm-none fw-bold">CSS</span>
    </a>
    <button class="navbar-toggler text-light position-absolute d-md-none collapsed" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav d-flex flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="/admin/dashboard">
                            <i class="bi bi-journal-text feather"></i>
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success ?>
                </div>
            <?php endif; ?>
            {{content}}
        </main>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Bootstrap Bundle JS, then Bootstrap Select JS -->
<script src="/js/lib/jquery/jquery-3.6.0.min.js"></script>
<script src="/js/lib/bootstrap/bootstrap.bundle.min.js"></script>
<?php foreach ($scripts as $script): ?>
    <?php if (is_array($script)): ?>
        <script type="module" src="/js/<?php echo $script[0] ?>.js"></script>
    <?php else: ?>
        <script src="/js/<?php echo $script ?>.js"></script>
    <?php endif; ?>
<?php endforeach; ?>

<script src="/js/lib/moment/moment.js"></script>
</body>
</html>
