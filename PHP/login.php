<?php
session_start();//Marca inicio de sesion
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo=["correo"];
    $clave=["clave"];

    $database=Data_base::getInstance();//Conexion base de datos

    $sql="SELECT nombre,tipo_usuario  from usuarios where correo=? AND clave =?";//Consulta preparada
    $parametros=['ss',$correo,$clave];
    $resultado=$database->login($sql,$parametros);//Ejecucion de la consulta y almacenamos resulatado

}
?>