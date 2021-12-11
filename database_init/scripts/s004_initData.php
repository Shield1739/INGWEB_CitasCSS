<?php

class s004_initData
{
    public function up()
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        return "
            INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 1, 'ABCDFG', '$date', 'asakjdhgask');
            INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 2, 2, 'AABBCC', '$date', 'asakj44354dhgask');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 3, 3, 'AAABBB', '$date', 'asdfssk');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 4, 'BBBCCC', '$date', 'Ayuda');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 7, 'GGGGGG', '$date', 'en serio, ayuda');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 1, 1, 9, 'FFFEEE', '$date', 'Tengo hambre');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 2, 3, 1, 'ADADCF', '$date', 'Me quede dormido en teams y se me partio el hombro');
INSERT INTO cita (citaEstadoID, citaDoctorID, citaPacienteID, citaBloqueHoraID, citaCodigoSeguimineto, citaFecha, citaMotivo) 
                VALUES (1, 2, 2, 4, 'CCDDFF', '$date', 'Ya toy mejor');
        ";
    }

    public function down()
    {
        return null;
    }
}