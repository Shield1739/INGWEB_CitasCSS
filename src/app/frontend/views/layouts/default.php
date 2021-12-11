<?php
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

        <title><?php echo $title ?? 'Citas CSS' ?></title>
    </head>

    <body>

        <header class="bg-light py-3 mb-4 border-bottom">
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="container-sm">
                    <a href="/" class="d-flex align-items-center mb-lg-0 text-dark text-decoration-none">
                        <img src="/media/logo.png" alt="" class="d-inline-block me-2" style="width: 60px; height: 60px">
                        <span class="d-block fs-4 text-primary fw-bold">CAJA DE SEGURO SOCIAL</span>
                    </a>
                </div>
            </div>
        </header>

        <div class="container">
            {{content}}
        </div>

    </body>
</html>
