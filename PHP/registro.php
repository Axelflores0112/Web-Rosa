<?php
require 'conexion.php';

//Comprobacion de que campos de fromualrio no estan vacios

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verificar si se ha enviado el formulario
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    $correo = $_POST["correo"];

    $database = new Data_base(); //Conexion a base de datos

    if (!empty('nombre') && !empty('clave') && !empty('correo')) {
        //Insercion a la base de datos
        $sql = "INSERT INTO usuarios (nombre,clave,correo) VALUES (?.?.?)"; //Aqui solamnete estamos preparando la consulta
        //Consulta preparada con los parametros
        $parametros = ['sss', $nombre, $clave, $correo]; //<-esta variable es un array que contiene los valores reales que se insertarán en la consulta SQL.
        //Insertamos los datos
        $database->register($sql, $parametros);

        //Cerrar conexion
        $database->close();
    }
}

?>