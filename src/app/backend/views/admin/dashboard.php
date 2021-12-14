<?php
/** @var $model Shield1739\UTP\CitasCss\app\backend\models\admin\AdminDashboardModel */

?>

<div class="container">
    <div class="h1 pb-3">
        Dashboard
    </div>
    <div class="container">
        <div class="row gy-3 pb-3">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Stats de Usuarios
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Cantidad</h5>
                        <div class="card-text fs-6">
                            <p class="fs-5 mb-1">Pacientes: <span class="fs-6"><?php echo $model->pacienteCount ?></span></p>
                            <p class="fs-5 mb-1">Doctores: <span class="fs-6"><?php echo $model->doctoresCount ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Stats de Citas
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Cantidad</h5>
                        <div class="card-text fs-6">
                            <p class="fs-5 mb-1">Citas: <span class="fs-6"><?php echo $model->citasCount ?></span></p>
                            <p class="fs-5 mb-1">Citas Agendadas: <span class="fs-6"><?php echo $model->citasAgendadasCount ?></span></p>
                            <p class="fs-5 mb-1">Citas Canceladas: <span class="fs-6"><?php echo $model->citasCanceladasCount ?></span></p>
                            <p class="fs-5 mb-1">Citas Terminadas: <span class="fs-6"><?php echo $model->citasTerminadasCount ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--        Clinicas -->
        <div class="accordion pb-3" id="clinicasAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="clinicasAccordionHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#clinicasAccordionCollapse" aria-expanded="true" aria-controls="clinicasAccordionCollapse">
                        Clinicas
                    </button>
                </h2>
                <div id="clinicasAccordionCollapse" class="accordion-collapse collapse show"
                     aria-labelledby="clinicasAccordionHeading" data-bs-parent="#clinicasAccordion">
                    <div class="accordion-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary p-1" data-bs-target="#clinicaCreateModal"
                                    data-mode="create" onclick="openClinicaModal(this)">
                                <i class="bi bi-plus-circle fs-5"></i>
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Direccion</th>
                                <th scope="col" class="text-end">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /** @var \Shield1739\UTP\CitasCss\app\entities\ClinicaEntity $clinica */
                            $i = 1;
                            foreach ($model->fetchAllClinicas() as $clinica): ?>
                                <tr>
                                    <th class="align-middle" scope="row"><?php echo $i ?></th>
                                    <th class="align-middle"><?php echo $clinica->clinicaID?></th>
                                    <th class="align-middle"><?php echo $clinica->clinicaNombre?></th>
                                    <th class="align-middle"><?php echo $clinica->clinicaDireccion?></th>
                                    <th class="align-middle text-end">
                                        <button type="button" class="btn btn-primary p-2" data-bs-target="#clinicaEditModal"
                                                data-mode="edit"
                                                data-id="<?php echo $clinica->clinicaID?>"
                                                data-nombre="<?php echo $clinica->clinicaNombre?>"
                                                data-direccion="<?php echo $clinica->clinicaDireccion?>"
                                                onclick="openClinicaModal(this)">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger p-2" data-bs-target="#clinicaDeleteModal"
                                                data-mode="delete"
                                                data-id="<?php echo $clinica->clinicaID?>"
                                                data-nombre="<?php echo $clinica->clinicaNombre?>"
                                                data-direccion="<?php echo $clinica->clinicaDireccion?>"
                                                onclick="openClinicaModal(this)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </th>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="clinicaCreateModal" tabindex="-1" aria-labelledby="clinicaCreateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clinicaCreateModalLabel">Crear Clinica</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="clinicaCreateModalClinicaNombre" name="clinicaNombre" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Direccion
                                        </h1>
                                        <input id="clinicaCreateModalClinicaDireccion" name="clinicaDireccion" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="createClinica" type="submit" class="btn btn-primary">Crear Clinica</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="clinicaEditModal" tabindex="-1" aria-labelledby="clinicaEditModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clinicaEditModalLabel">Editar Clinica</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="clinicaEditModalClinicaID" class="h5">Clinica ID</label>
                                        <input id="clinicaEditModalClinicaID" name="clinicaID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="clinicaEditModalClinicaNombre" name="clinicaNombre" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Direccion
                                        </h1>
                                        <input id="clinicaEditModalClinicaDireccion" name="clinicaDireccion" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="editClinica" type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="clinicaDeleteModal" tabindex="-1" aria-labelledby="clinicaDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clinicaDeleteModalLabel">Borrar Clinica</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="clinicaDeleteModalClinicaID" class="h5">Clinica ID</label>
                                        <input id="clinicaDeleteModalClinicaID" name="clinicaID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="clinicaDeleteModalClinicaNombre" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Direccion
                                        </h1>
                                        <input id="clinicaDeleteModalClinicaDireccion" value="" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="deleteClinica" type="submit" class="btn btn-danger">Borrar Clinica</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--        Especialidades -->
        <div class="accordion pb-3" id="especialidadesAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#especialidadesAccordionCollapse" aria-expanded="true" aria-controls="especialidadesAccordionCollapse">
                        Especialidades
                    </button>
                </h2>
                <div id="especialidadesAccordionCollapse" class="accordion-collapse collapse show"
                     aria-labelledby="headingOne" data-bs-parent="#especialidadesAccordion">
                    <div class="accordion-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary p-1" data-bs-target="#especialidadCreateModal"
                                    data-mode="create" onclick="openEspecialidadModal(this)">
                                <i class="bi bi-plus-circle fs-5"></i>
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col" class="text-end">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /** @var \Shield1739\UTP\CitasCss\app\entities\EspecialidadEntity $especialidad */
                            $i = 1;
                            foreach ($model->fetchAllEspecialidades() as $especialidad): ?>
                                <tr>
                                    <th class="align-middle" scope="row"><?php echo $i ?></th>
                                    <th class="align-middle"><?php echo $especialidad->especialidadID?></th>
                                    <th class="align-middle"><?php echo $especialidad->especialidadNombre?></th>
                                    <th class="align-middle text-end">
                                        <button type="button" class="btn btn-primary p-2" data-bs-target="#especialidadEditModal"
                                                data-mode="edit"
                                                data-id="<?php echo $especialidad->especialidadID?>"
                                                data-nombre="<?php echo $especialidad->especialidadNombre?>"
                                                onclick="openEspecialidadModal(this)">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger p-2" data-bs-target="#especialidadDeleteModal"
                                                data-mode="delete"
                                                data-id="<?php echo $especialidad->especialidadID?>"
                                                data-nombre="<?php echo $especialidad->especialidadNombre?>"
                                                onclick="openEspecialidadModal(this)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </th>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="especialidadCreateModal" tabindex="-1" aria-labelledby="especialidadCreateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="especialidadCreateModalLabel">Crear Especialidad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="especialidadCreateModalEspecialidadNombre" name="especialidadNombre" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="createEspecialidad" type="submit" class="btn btn-primary">Crear Especialidad</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="especialidadEditModal" tabindex="-1" aria-labelledby="especialidadEditModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="especialidadEditModalLabel">Editar Especialidad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="especialidadEditModalEspecialidadID" class="h5">Especialidad ID</label>
                                        <input id="especialidadEditModalEspecialidadID" name="especialidadID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="especialidadEditModalEspecialidadNombre" name="especialidadNombre" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="editEspecialidad" type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="especialidadDeleteModal" tabindex="-1" aria-labelledby="especialidadDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="especialidadDeleteModalLabel">Borrar Especialidad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="especialidadDeleteModalEspecialidadID" class="h5">Especialidad ID</label>
                                        <input id="especialidadDeleteModalEspecialidadID" name="especialidadID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="especialidadDeleteModalEspecialidadNombre" value="" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="deleteEspecialidad" type="submit" class="btn btn-danger">Borrar Especialidad</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--        Doctores -->
        <div class="accordion pb-3" id="doctoresAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#doctoresAccordionCollapse" aria-expanded="true" aria-controls="doctoresAccordionCollapse">
                        Doctores
                    </button>
                </h2>
                <div id="doctoresAccordionCollapse" class="accordion-collapse collapse show"
                     aria-labelledby="headingOne" data-bs-parent="#doctoresAccordion">
                    <div class="accordion-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary p-1" data-bs-target="#doctorCreateModal"
                                    data-mode="create" onclick="openDoctorModal(this)">
                                <i class="bi bi-plus-circle fs-5"></i>
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Cuenta ID</th>
                                <th scope="col">Cedula</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col" class="text-end">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /** @var \Shield1739\UTP\CitasCss\app\entities\DoctorEntity $doctor */
                            $i = 1;
                            foreach ($model->fetchAllDoctores() as $doctor): ?>
                                <tr>
                                    <th class="align-middle" scope="row"><?php echo $i ?></th>
                                    <th class="align-middle"><?php echo $doctor->doctorID?></th>
                                    <th class="align-middle"><?php echo $doctor->cuentaID?></th>
                                    <th class="align-middle"><?php echo $doctor->cuentaCedula?></th>
                                    <th class="align-middle"><?php echo $doctor->cuentaNombre?></th>
                                    <th class="align-middle"><?php echo $doctor->cuentaApellido?></th>
                                    <th class="align-middle text-end">
                                        <button type="button" class="btn btn-primary p-2" data-bs-target="#doctorEditModal"
                                                data-mode="edit"
                                                data-id="<?php echo $doctor->doctorID?>"
                                                data-cuenta-id="<?php echo $doctor->cuentaID?>"
                                                data-correo="<?php echo $doctor->cuentaCorreo?>"
                                                data-cedula="<?php echo $doctor->cuentaCedula?>"
                                                data-nombre="<?php echo $doctor->cuentaNombre?>"
                                                data-apellido="<?php echo $doctor->cuentaApellido?>"
                                                data-clinica-id="<?php echo $doctor->doctorClinicaID?>"
                                                onclick="openDoctorModal(this)">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger p-2" data-bs-target="#doctorDeleteModal"
                                                data-mode="delete"
                                                data-id="<?php echo $doctor->doctorID?>"
                                                data-cuenta-id="<?php echo $doctor->cuentaID?>"
                                                data-correo="<?php echo $doctor->cuentaCorreo?>"
                                                data-cedula="<?php echo $doctor->cuentaCedula?>"
                                                data-nombre="<?php echo $doctor->cuentaNombre?>"
                                                data-apellido="<?php echo $doctor->cuentaApellido?>"
                                                data-clinica-id="<?php echo $doctor->doctorClinicaID?>"
                                                onclick="openDoctorModal(this)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </th>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="doctorCreateModal" tabindex="-1" aria-labelledby="doctorCreateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="doctorCreateModalLabel">Crear Doctor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Correo
                                        </h1>
                                        <input id="doctorCreateModalDoctorCorreo" name="doctorCorreo" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Cedula
                                        </h1>
                                        <input id="doctorCreateModalDoctorCedula" name="doctorCedula" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="doctorCreateModalDoctorNombre" name="doctorNombre" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Apellido
                                        </h1>
                                        <input id="doctorCreateModalDoctorApellido" name="doctorApellido" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Contraseña
                                        </h1>
                                        <input id="doctorCreateModalDoctorContrasena" name="doctorContrasena" type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="createDoctor" type="submit" class="btn btn-primary">Crear Doctor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="doctorEditModal" tabindex="-1" aria-labelledby="doctorEditModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="doctorEditModalLabel">Editar Doctor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="doctorEditModalDoctorID" class="h5">Doctor ID</label>
                                        <input id="doctorEditModalDoctorID" name="doctorID" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="doctorEditModalDoctorCuentaID" class="h5">Cuenta ID</label>
                                        <input id="doctorEditModalDoctorCuentaID" name="doctorCuentaID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Correo
                                        </h1>
                                        <input id="doctorEditModalDoctorCorreo" name="doctorCorreo" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Cedula
                                        </h1>
                                        <input id="doctorEditModalDoctorCedula" name="doctorCedula" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="doctorEditModalDoctorNombre" name="doctorNombre" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Apellido
                                        </h1>
                                        <input id="doctorEditModalDoctorApellido" name="doctorApellido" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Contraseña
                                        </h1>
                                        <input id="doctorEditModalDoctorContrasena" name="doctorContrasena" type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Clinica
                                        </h1>
                                        <select id="doctorEditModalDoctorClinica" class="selectpicker form-control" name="clinicaID" title="---" data-actions-box="true"></select>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h1 class="h5">
                                            Especialidades
                                        </h1>
                                        <table id="doctorEspecialidadTable" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Id</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col" class="text-end">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col pb-4">
                                        <h1 class="h5">
                                            Agregar Especialidad
                                        </h1>
                                        <select id="doctorEditModalDoctorEspecialidad" class="selectpicker form-control" name="especialidadID" data-actions-box="true"></select>
                                    </div>
                                    <div class="d-block">
                                        <button name="addDoctorEspecialidad" type="submit" class="btn btn-primary">Agregar Especialidad</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="editDoctor" type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="doctorDeleteModal" tabindex="-1" aria-labelledby="doctorDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="doctorDeleteModalLabel">Borrar Doctor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <label for="doctorDeleteModalDoctorID" class="h5">Doctor ID</label>
                                        <input id="doctorDeleteModalDoctorID" name="doctorID" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="doctorDeleteModalDoctorCuentaID" class="h5">Cuenta ID</label>
                                        <input id="doctorDeleteModalDoctorCuentaID" name="doctorCuentaID" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Correo
                                        </h1>
                                        <input id="doctorDeleteModalDoctorCorreo" name="doctorCorreo" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Cedula
                                        </h1>
                                        <input id="doctorDeleteModalDoctorCedula" name="doctorCedula" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Nombre
                                        </h1>
                                        <input id="doctorDeleteModalDoctorNombre" name="doctorNombre" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <h1 class="h5">
                                            Apellido
                                        </h1>
                                        <input id="doctorDeleteModalDoctorApellido" name="doctorApellido" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button name="deleteDoctor" type="submit" class="btn btn-danger">Borrar Doctor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
