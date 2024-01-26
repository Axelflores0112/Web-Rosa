<?php
    class Data_base{
        private $host ="localhost";
        private $user ="root";
        private $pass ="";
        private $db="web_rosa";
        protected $conexion;
    
        public function __construct(){
            $this->conexion();
        }//Con esto cada vez que se crea un objeto de la clase se establece una conexion a la base de datos.

        public function conexion(){ //Metodo para establecer conexion base de datos
            try{
                $this->conexion=new mysqli($this->host,$this->user,$this->pass,$this->db);
            }catch(Exception $error){//Si hay un problema, se mostrara error y obtendra que tipo de errror es
                die($error->getMessage());
            }
        }

        public function close(){//metdodo para cerrar la conexion a la base de datos
            if($this->conexion){
                $this->conexion ->close();
            }
        }

        public function register($sql,$parametros){//Metodo para poder registrar usuarios
            try{
                $statement=$this->conexion->prepare($sql);//Preparar consulta sql que se vaya a usar(va de la mano con lo de sentencias prepradas)
                if(!$statement){
                    throw new Exception("Error en la preparacion".$this->conexion->error);//Comprobar si no hubo error al preparar consulta, si lo hay lo muestra
                }
                if(!empty($parametros)){
                    $tipos=array_shift($parametros);//Elimina el primer elemnto del array (en este caso 'sss' (que mamada))
                    $statement->bind_param($tipos,...$parametros);//Pasamos tipo de datos que entraran a la base de datos y sepramos lo almacenado enn parametros
                }
                $resultado=$statement->execute();//Ejecutamos la consulta
                if(!$resultado){
                    throw new Exception("Error al insertar en la Base de Datos");
                }

                $statement->close();//terminar consulta
            }catch(Exception $error){
                die($error->getMessage());// Manejar cualquier excepción y detener la ejecución con un mensaje de error
            }
            
        }
    }
?>