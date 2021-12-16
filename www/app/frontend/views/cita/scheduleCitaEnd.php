<?php
/** @var $model Shield1739\UTP\CitasCss\app\frontend\models\cita\ScheduleCitaModel */

?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h2 fw-bold">Agendar Cita</h1>
    </div>
    <div class="d-block text-dark text-center">
        <h1 class="h3 fw-bold">¡Gracias por agendar tu cita!</h1>
        <p class="h4">
            Tu codigo de seguimiento es: <span class="h4 fw-bold text-primary"><?php echo $model->cita->citaCodigoSeguimineto ?></span>
        </p>
        <div class="container-sm d-flex justify-content-center">
            <img class="d-none d-md-block" src="/media/cita.png" style="width: 600px; height: 400px">
        </div>
        <div class="d-block pb-5">
            <h1 class="h4 text-dark">
                <span class="h4 text-danger">Importante:</span> Con este codigo puedes dar seguimineto a tu cita, ¡No lo pierdas!
            </h1>
        </div>
    </div>
</div>
