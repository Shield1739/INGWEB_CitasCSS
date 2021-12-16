<?php

class s004_initData
{
    public function up()
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        return "
            INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 1, 'ABCDFG', '2021/12-13', 'asakjdhgask');
            INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 2, 2, 'AABBCC', '2021/12-13', 'asakj44354dhgask');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 3, 3, 'AAABBB', '2021/12-13', 'asdfssk');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 4, 'BBBCCC', '2021/12-13', 'Ayuda');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 7, 'GGGGGG', '2021/12-13', 'en serio, ayuda');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 9, 'FFFEEE', '2021/12-13', 'Tengo hambre');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 2, 3, 1, 'ADADCF', '2021/12-13', 'Me quede dormido en teams y se me partio el hombro');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 2, 2, 4, 'CCDDFF', '2021/12-13', 'Ya toy mejor');    
                INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                    VALUES (1, 2, 2, 4, 'CLKHJD', '2021/12/20', '...');
                INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                    VALUES (1, 1, 1, 1, 'CPKHJD', '2021/12/20', '...');
                INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                    VALUES (1, 2, 1, 8, 'CLJHJD', '2021/12/20', '...');
        ";
    }

    public function down()
    {
        return null;
    }
}