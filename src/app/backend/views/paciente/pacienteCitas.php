<?php
/** @var $model Shield1739\UTP\CitasCss\app\backend\models\paciente\PacienteCitasModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h3 fw-bold">Mis Citas</h1>
    </div>
    <div class="container mx-2 p-0">
        <table id="citasTable" class="table table-striped table-sm">
            <thead>
                <tr class="fs-5">
                    <th scope="col">
                        Clinica
                    </th>
                    <th scope="col">
                        Doctor
                    </th>
                    <th scope="col">
                        Fecha
                    </th>
                    <th scope="col">
                        Hora
                    </th>
                    <th scope="col">
                        Codigo
                    </th>
                    <th scope="col" style="width: 1px">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if($model->citas): ?>
                    <input id="selectedCitaID" value="<?php echo $model->citaID?>" hidden>
                    <input id="selectedDoctorID" value="<?php echo $model->doctorID?>" hidden>
                    <?php foreach ($model->citas as $cita): ?>
                        <tr class="fs-6">
                            <td class="align-middle">
                                <?php echo $cita->clinicaNombre ?>
                            </td>
                            <td class="align-middle">
                                <?php echo $cita->getDoctorFullName() ?>
                            </td>
                            <td class="align-middle">
                                <?php echo $cita->citaFecha ?>
                            </td>
                            <td class="align-middle">
                                <?php echo $cita->horaInicio ?>
                            </td>
                            <td class="align-middle">
                                <?php echo $cita->citaCodigoSeguimineto ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#citaInfoModal<?php echo $cita->citaID?>">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button type="button" class="btn btn-danger p-2" data-bs-toggle="modal" data-bs-target="#citaCancelModal<?php echo $cita->citaID?>">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="citaInfoModal<?php echo $cita->citaID?>"
                             tabindex="-1" aria-labelledby="citaInfoModalLabel<?php echo $cita->citaID?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title h4" id="citaInfoModalLabel<?php echo $cita->citaID?>">Informacion de la Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Clinica
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->clinicaNombre?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Direccion
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->clinicaDireccion?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Doctor
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->getDoctorFullName()?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-5">
                                                <h1 class="h5 fw-bold">
                                                    Fecha
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->citaFecha?>" type="date" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <h1 class="h5 fw-bold">
                                                    Hora
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->horaInicio?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-5">
                                                <h1 class="h5 fw-bold">
                                                    Codigo
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->citaCodigoSeguimineto?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-5">

                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Motivo
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <textarea type="date" class="form-control" disabled><?php echo $cita->citaMotivo?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                                data-bs-toggle="modal" data-bs-target="#citaRescheduleModal<?php echo $cita->citaID?>">Reprogramar Cita</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="citaCancelModal<?php echo $cita->citaID?>"
                             tabindex="-1" aria-labelledby="citaCancelModalLabel<?php echo $cita->citaID?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="citaCancelModalLabel<?php echo $cita->citaID?>">Cancelar Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-block pb-3 fs-4 text-center">
                                            ¿Esta seguro que desea cancelar esta cita?
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Clinica
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->clinicaNombre?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-10">
                                                <h1 class="h5 fw-bold">
                                                    Doctor
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->getDoctorFullName()?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gx-3 gy-3 pb-3">
                                            <div class="col-5">
                                                <h1 class="h5 fw-bold">
                                                    Fecha
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->citaFecha?>" type="date" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <h1 class="h5 fw-bold">
                                                    Hora
                                                </h1>
                                                <div class="d-block fs-6">
                                                    <input value="<?php echo $cita->horaInicio?>" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="" method="post">
                                            <input name="citaID" value="<?php echo $cita->citaID?>" hidden>
                                            <button name="cancel" type="submit" class="btn btn-danger">Cancelar Cita</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="citaRescheduleModal<?php echo $cita->citaID?>"
                             tabindex="-1" aria-labelledby="citaRescheduleModalLabel<?php echo $cita->citaID?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="citaRescheduleModalLabel<?php echo $cita->citaID?>">Cancelar Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="d-block pb-3 fs-4">
                                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                                    <div class="col-10">
                                                        <h1 class="h5 fw-bold">
                                                            Clinica
                                                        </h1>
                                                        <div class="d-block fs-6">
                                                            <input value="<?php echo $cita->clinicaNombre?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                                    <div class="col-10">
                                                        <h1 class="h5 fw-bold">
                                                            Doctor
                                                        </h1>
                                                        <div class="d-block fs-6">
                                                            <input value="<?php echo $cita->getDoctorFullName()?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
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

                                                            $fechaField->setIdPrefix($cita->citaID);
                                                            $fechaField->setOnChange("loadHoras(this, $cita->citaDoctorID, $cita->citaID);");

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
                                                                $bloqueHoraSelect->setIdPrefix($cita->citaID);
                                                                $bloqueHoraSelect->setDisabled(true);
                                                                echo $bloqueHoraSelect;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    data-bs-toggle="modal" data-bs-target="#citaInfoModal<?php echo $cita->citaID?>">Atras</button>
                                            <button name="reschedule" type="submit" class="btn btn-primary">Confirmar Reprogramacion</button>
                                            <input name="citaID" value="<?php echo $cita->citaID?>" hidden>
                                            <input name="doctorID" value="<?php echo $cita->citaDoctorID?>" hidden>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="py-4 fs-5 text-center text-muted fst-italic" colspan="6">
                            No tiene ninguna cita programada
                            <br>
                            Puede agendar una <a href="/citas/agendar">aqui</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
