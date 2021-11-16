<?php
function traducirDia($dia)
{
    $todoDias = array(
        "Monday" => "Lunes", "Tuesday" => "Martes",
        "Wednesday" => "Miercoles", "Thursday" => "Jueves", "Friday" => "Viernes",
        "Saturday" => "Sabado", "Sunday" => "Domingo");
            return $todoDias[$dia];
}

function traducirMes($mes)
{
    $todoMes = array(
        "January" => "Enero", "February" => "Febrero", "March" => "Marzo",
        "April" => "Abril", "May" => "Mayo", "June" => "Junio",
        "July" => "Julio", "August" => "Agosto", "September" => "Septiembre",
        "October" => "Octubre", "November" => "Noviembre", "December" => "Diciembre",);
            return $todoMes[$mes];
}
