<?php

class s002_initData
{
    public function up(): string
    {
        return "
            INSERT INTO cuentatipo (cuentaTipoID, cuentaTipoNombre) VALUES (1, 'Admin'), (2, 'Paciente'), (3, 'Doctor');
            INSERT INTO citaestado (citaEstadoID, citaEstadoNombre) VALUES (1, 'Agendada'), (2, 'Terminada') , (3, 'Cancelada');
            INSERT INTO especialidad (especialidadID, especialidadNombre) VALUES (1, 'Ortopedia'), (2, 'Cardiologia'), 
                                                                                 (3, 'Pediatría'), (4, 'Dermatologia'), (5 , 'Hematología');
            INSERT INTO clinica (clinicaID, clinicaNombre, clinicaDireccion) VALUES (1, 'Policlínica Especializada de la CSS', 'C. José de Fábrega, Panamá'),
                                                                                    (2, 'Policlínica Dr. Generoso Guardia', '3FCV+VVQ, Panamá'),
                                                                                    (3, 'Policlínica de San Francisco de la CSS', 'Av. Belisario Porras, Panamá'),
                                                                                    (4, 'Policlínica Dr. Manuel Ferrer Valdés', 'Avenida Justo Arosemena, C. 24 Este, Panamá'),
                                                                                    (5, 'Policlínica de la CSS Dr. Carlos N. Brin', 'Av. Belisario Porras, Panamá');
            INSERT INTO bloquehora (bloqueHoraID, bloqueHoraHoraInicio) VALUES (1, '08:00'), (2, '08:30'), (3, '09:00'),
                                                                     (4, '09:30'), (5, '10:00'), (6, '10:30'),
                                                                     (7, '11:00'), (8, '11:30'), (9, '13:00'),
                                                                     (10, '13:30'), (11, '14:00'), (12, '14:30'),
                                                                     (13, '15:00'), (14, '15:30');
        ";
    }

    public function down()
    {
        return null;
    }
}