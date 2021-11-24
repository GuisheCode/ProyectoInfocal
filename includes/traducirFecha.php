<?php
function traducirDia($dia)
{
    $todoDias = array(
        "Monday" => "Lunes", "Tuesday" => "Martes",
        "Wednesday" => "Miércoles", "Thursday" => "Jueves", "Friday" => "Viernes",
        "Saturday" => "Sábado", "Sunday" => "Domingo");
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

function traducirDiaComparar($dia)
{
    $todoDias = array(
        "Monday" => "lunes", "Tuesday" => "martes",
        "Wednesday" => "miercoles", "Thursday" => "jueves", "Friday" => "viernes",
        "Saturday" => "sabado", "Sunday" => "domingo");
            return $todoDias[$dia];
}