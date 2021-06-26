<?php
session_start();

include_once 'conexion.php';
$objeto = new Database();

//recepción de datos enviados mediante POST desde ajax
$usuario  = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

//$pass = md5($password); //encripto la clave enviada por el usuario para compararla con la clava encriptada y almacenada en la BD

$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password' ";

$resultado = $objeto->run($consulta);

if (is_array($resultado) && count($resultado) > 0) {
    $data         = $resultado[0];
    $_SESSION["s_usuario"] = $resultado[0]["usuario"];
} else {
    $_SESSION["s_usuario"] = null;
    $data = null;
}

print json_encode($data);
$objeto = null;

//usuarios de pruebaen la base de datos
//usuario:admin pass:12345
//usuario:demo pass:demo