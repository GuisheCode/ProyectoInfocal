<?php
ob_start();
session_start();

// Definimos la zona horaria
// date_default_timezone_set('Europe/London');
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/La_Paz');
//Credenciale de base de datos
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','infocal');

// Direccion de la app - PHP MAILER
define('DIR','http://domain.com/');
define('SITEEMAIL','noreply@domain.com');

try {

	//Creamos la conexion PDO
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//Muestra errores
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}


class Conexion {

    private $conexion;
    private $configuracion = [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "infocal",
        "port" => "3306",
        "username" => "root",
        "password" => "",
        "charset" => "utf8mb4"
    ];

    public function __construct() {
        
    }

    public function conectar() {
        try {
            $CONTROLADOR = $this->configuracion["driver"];
            $SERVIDOR = $this->configuracion["host"];
            $BASE_DATOS = $this->configuracion["database"];
            $PUERTO = $this->configuracion["port"];
            $USUARIO = $this->configuracion["username"];
            $CLAVE = $this->configuracion["password"];
            $CODIFICACION = $this->configuracion["charset"];

            $url = "{$CONTROLADOR}:host={$SERVIDOR}:{$PUERTO};"
                    . "dbname={$BASE_DATOS};charset={$CODIFICACION}";
            //Se crea la conexión.
            $this->conexion = new PDO($url, $USUARIO, $CLAVE);
            // echo "";
            return $this->conexion;
        } catch (Exception $exc) {
            echo "NO SE PUDO CONECTAR";
            echo $exc->getTraceAsString();
        }
    }

}


$raiz = $_SERVER["DOCUMENT_ROOT"];
// Incluimos la clase User
include($raiz.'/proyectoinfocal/classes/user.php');
include($raiz.'/proyectoinfocal/classes/phpmailer/mail.php');
$user = new User($db);
?>
