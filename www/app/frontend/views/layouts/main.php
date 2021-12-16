<?php
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
        <link rel="stylesheet" href="/css/default.css">

        <title><?php echo $title ?? 'Citas CSS' ?></title>
    </head>

    <body>
        <div id="main-container">
            <header class="bg-light">
                <nav class="py-2 border-bottom">
                    <div class="container d-flex flex-wrap justify-content-end">
                        <a href="/iniciar-sesion" class="btn btn-primary me-2">Iniciar Sesion</a>
                        <a href="/registrarse" class="btn btn-secondary">Registrarse</a>
                    </div>
                </nav>
                <div class="py-3 mb-4 border-bottom">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-sm">
                            <a href="/" class="d-flex align-items-center mb-lg-0 text-dark text-decoration-none">
                                <img src="/media/logo.png" alt="" class="d-inline-block me-2" style="width: 60px; height: 60px">
                                <span class="d-none d-sm-block fs-4 text-primary fw-bold">CAJA DE SEGURO SOCIAL</span>
                                <span class="d-block d-sm-none fs-4 text-primary fw-bold">CSS</span>
                            </a>
                            <button class="navbar-toggler" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#headerNavbar"
                                    aria-controls="headerNavbar" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="headerNavbar">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="/" class="nav-link px-3 text-primary fs-5 fw-bold" >Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/citas/agendar" class="nav-link px-3 text-primary fs-5 fw-bold">Agendar Cita</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/citas/consultar" class="nav-link px-3 text-primary fs-5 fw-bold">Consultar Cita</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>

            <div id="content-container" class="container h-100 m-auto">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo $success ?>
                    </div>
                <?php endif; ?>
                {{content}}
            </div>

            <footer class="w-100">
                <div class="container d-flex align-items-center justify-content-between h-100">
                    <div>
                        <img src="/media/logo-extended.png" alt="">
                    </div>
                    <div class="d-flex flex-row footer-logos">
                        <a href="https://www.youtube.com/watch?v=yi_ppuOMgSc&ab_channel=Penjboy"><h2 class="bi bi-youtube ps-3 text-light"></h2></a>
                        <h2 class="bi bi-github ps-3"></h2>
                    </div>
                </div>
            </footer>
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