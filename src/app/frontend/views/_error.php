<?php
/** @var $exception \Exception **/

?>

<div class="text-center py-5">
    <h1 class="h1">Error <?php echo $exception->getCode() ?> </h1>
    <h1 class="h2"><?php echo $exception->getMessage() ?></h1>
    <a class="btn btn-primary btn-lg" href="/">
        Volver al Inicio
    </a>
</div>