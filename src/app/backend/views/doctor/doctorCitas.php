<?php
/** @var $model Shield1739\UTP\CitasCss\app\backend\models\doctor\DoctorCitasModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h3 fw-bold">Mis Citas</h1>
    </div>
    <div class="container mx-2 p-0">
        <input id="selectedCitaID" value="<?php echo $model->citaID?>" hidden>
        <input id="selectedDoctorID" value="<?php echo $model->doctorID?>" hidden>
        <div class="d-flex align-items-center pb-3 px-3">
            <span id="menu-navi">
                <button id="hoyButton" type="button" class="btn btn-light btn-" data-action="move-today">Hoy</button>
                <button id="prevButton" type="button" class="btn btn-light" data-action="move-prev">
                    <i class="bi bi-caret-left-fill" data-action="move-prev"></i>
                </button>
                <button id="nextButton" type="button" class="btn btn-light" data-action="move-next">
                    <i class="bi bi-caret-right-fill" data-action="move-next"></i>
                </button>
            </span>
            <span id="rangeSpan" class="ps-2 fs-5 fw-bold"></span>
        </div>
        <div id="calendar"></div>
        <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rescheduleModalLabel">Reprogramar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="d-block pb-3 fs-4">
                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                    <div class="col-5">
                                        <h1 class="h5 fw-bold">
                                            Fecha
                                        </h1>
                                        <div class="d-block fs-6">
                                            <?php
                                            $fechaField = $formBuilder->renderSingleInputField('fecha');
                                            $fechaField->setFieldTypeDate();

                                            $minDate = new DateTime();
                                            $minDate->modify('+1 day');
                                            $maxDate = new DateTime();
                                            $maxDate->modify('+6 months');

                                            $fechaField->setMin($minDate->format('Y-m-d'));
                                            $fechaField->setMax($maxDate->format('Y-m-d'));

                                            //$fechaField->setOnChange("loadHoras(this, $cita->citaDoctorID, $cita->citaID);");

                                            echo $fechaField;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h1 class="h5 fw-bold">
                                            Hora
                                        </h1>
                                        <div class="d-block fs-6">
                                            <?php
                                            $bloqueHoraSelect = $formBuilder->renderSelectField('bloqueHoraID', $model->getAllHorasOptions());
                                            //$bloqueHoraSelect->setIdPrefix($cita->citaID);
                                            $bloqueHoraSelect->setDisabled(true);
                                            echo $bloqueHoraSelect;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button name="reschedule" type="submit" class="btn btn-primary">Repgrogramar Cita</button>
                            <input type="hidden" id="citaID" name="citaID" value="<?php echo $model->citaID?>">
                            <input type="hidden" id="doctorID" name="doctorID" value="<?php echo $model->doctorID?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancelModal"
             tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelModalLabel">Cancelar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-block pb-3 fs-4 text-center">
                            ¿Esta seguro que desea cancelar esta cita?
                        </div>
                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                            <div class="col-5">
                                <h1 class="h5 fw-bold">
                                    Fecha
                                </h1>
                                <div class="d-block fs-6">
                                    <input id="cancelFecha" value="" type="date" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-5">
                                <h1 class="h5 fw-bold">
                                    Hora
                                </h1>
                                <div class="d-block fs-6">
                                    <input id="cancelHora" value="" type="text" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <form action="" method="post">
                            <input id="cancelCitaID" name="citaID" type="hidden" value="" >
                            <button name="cancel" type="submit" class="btn btn-danger">Cancelar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
