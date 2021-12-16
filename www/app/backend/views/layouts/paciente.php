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
        <button class="navbar-toggler text-light position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav d-none d-md-block me-3">
            <div class="nav-item text-nowrap">
                <a class="btn btn-secondary" href="/paciente/cuenta">
                    <i class="bi bi-gear-fill"></i>
                    Mi Cuenta
                </a>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav d-flex flex-column">
                        <li class="nav-item">
                            <a class="nav-link active fs-4" href="/paciente/citas">
                                <i class="bi bi-journal-text feather"></i>
                                Mis Citas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4" href="/citas/agendar">
                                <i class="bi bi-journal-album feather"></i>
                                Agendar Cita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4" href="/citas/consultar">
                                <i class="bi bi-journal-check feather"></i>
                                Consultar Cita
                            </a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link fs-4" href="/paciente/cuenta">
                                <i class="bi bi-gear-fill feather"></i>
                                Mi Cuenta
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
    <script src="/js/<?php echo $script ?>.js"></script>
<?php endforeach; ?>
</body>
</html>
