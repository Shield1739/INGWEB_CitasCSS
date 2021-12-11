<?php
/** @var $model Shield1739\UTP\CitasCss\app\frontend\models\cita\ConsultCitaModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
$formBuilder->addEntity('cita', $model->cita);
$formBuilder->addEntity('citaPacienteInfo', $model->citaPacienteInfo);

?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h3 fw-bold">Codigo de Seguimiento</h1>
    </div>
    <div id="appointmentAccordion" class="accordion">
        <div class="accordion-item">
            <h1 id="consultCitaHeading" class="accordion-header">
                <button class="accordion-button <?php echo $model->validCodigo ? 'collapsed' : '' ?>"
                        type="button" data-bs-toggle="collapse" data-bs-target="#consultCita"
                        aria-expanded="<?php echo $model->validCodigo ? 'false' : 'true' ?>" aria-controls="consultCita">
                    <span class="h4">Consultar Cita</span>
                </button>
            </h1>
            <div id="consultCita" class="accordion-collapse collapse <?php echo $model->validCodigo ? '' : 'show' ?>">
                <div class="accordion-body">
                    <div class="container-sm">
                        <div class="d-block text-center pb-3">
                            <h1 class="h4">Introduzca su codigo</h1>
                        </div>
                        <form action="" method="post">
                            <div class="d-block pb-3">
                                <div class="row justify-content-md-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-upc-scan fs-3"></i></span>
                                            <?php
                                            $codigoField = $formBuilder->renderFloatingInputField('codigoSeguimiento', 'Codigo de Seguimiento');
                                            $codigoField->setMax(6);
                                            echo $codigoField;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-center pb-3">
                                <button class="btn btn-primary btn-lg" type="submit">Consultar Cita</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item" <?php echo is_null($model->codigoSeguimiento) ? 'hidden' : ''?>>
            <h1 id="citaInfoHeading" class="accordion-header">
                <button class="accordion-button"
                        type="button" data-bs-toggle="collapse" data-bs-target="#citaInfo"
                        aria-expanded="true" aria-controls="citaInfo">
                    <span class="h4">Consultar Cita</span>
                </button>
            </h1>
            <div id="citaInfo" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="container-sm">
                        <div class="d-block text-center pb-3">
                            <h1 class="h4">Informacion de su cita</h1>
                        </div>
                        <?php if ($model->validCodigo): ?>
                            <div class="d-block">
                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Clinica
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $clinicaField = $formBuilder->renderSingleInputField('clinicaNombre', 'cita');
                                            $clinicaField->setDisabled(true);
                                            echo $clinicaField;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Doctor
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $doctorField = $formBuilder->renderSingleInputField('doctorCuentaNombre', 'cita');
                                            $doctorField->setValue($model->cita->getDoctorFullName());
                                            $doctorField->setDisabled(true);
                                            echo $doctorField;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Fecha
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $fechaField = $formBuilder->renderSingleInputField('citaFecha', 'cita');
                                            $fechaField->setFieldTypeDate();
                                            $fechaField->setDisabled(true);
                                            echo $fechaField;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Hora
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $horaField = $formBuilder->renderSingleInputField('horaInicio', 'cita');
                                            $horaField->setDisabled(true);
                                            echo $horaField;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="d-block">
                                <h1 class="h5 text-center text-danger">Cita no encontrada</h1>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
