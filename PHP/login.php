<?php
session_start(); //Marca inicio de sesion
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    
    $database= Data_base::getInstance();

    $sql = "SELECT nombre,clave,correo,tipo_usuario  from usuarios where correo=? AND clave =?"; //Consulta preparada
    $parametros = ['ss', $correo, $clave];

    $resultado = $database->login($sql, $parametros); //Ejecucion de la consulta y almacenamos resultado
    if(!$resultado){
        echo "todo mal";
    }
        if ($resultado && $row = $resultado->fetch_assoc()) { //Validar si la consulta no tuvo error y almacenar lo de la tabla en array asociativo

            if ($correo == $row['correo'] && $clave==$row['clave']) {
                $_SESSION["usuario"] = $row['nombre'];
                session_write_close();
                if ($row['tipo_usuario'] == 1) {
                    header("Location: ../HTML/Presentacion.html");
                } else{
                    header("Location: ../HTML/Productos.html");
                }
            }
        }else{
            echo  "<script>alert('Usuario o contraseña incorrectos')</script>";
        }

}
