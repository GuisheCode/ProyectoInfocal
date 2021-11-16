<?php
require('../../includes/config.php');
$hora = date('Gis');
if ($hora>=000000 && $hora <= 120000) {
    header('Location: horario/manana.php');
}
if ($hora>=120000&&$hora<=180000) {
    header('Location: horario/tarde.php');
}
if($hora>=180000&&$hora<=235959){
    header('Location: horario/noche.php');
}
?>