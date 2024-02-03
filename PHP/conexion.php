<?php
    class Data_base{
        private $host ="localhost";
        private $user ="root";
        private $pass ="";
        private $db="web_rosa";
        protected $conexion;
        private static $instancia;//Variable para generar instancia unica aplicando singletone
    
        private function __construct(){
            $this->conexion=new mysqli($this->host,$this->user,$this->pass,$this->db);
        }//Con esto cada vez que se crea un objeto de la clase se establece una conexion a la base de datos.

        public static function getInstance(){ //Metodo para establecer conexion base de datos con singletone
            if(self::$instancia===null){
                self::$instancia= new self();
            }
            return self::$instancia;
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
                    $statement->bind_param($tipos,...$parametros);//Pasamos tipo de datos que entraran a la base de datos y separamos lo almacenado en parametros
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

        public function login($sql,$parametros){
            try{
                $statment=$this->conexion->prepare($sql);//preparar consulta sql

                if(!$statment){
                    throw new Exception("Error en preparacion".$this->conexion->error);
                }
                if(!empty($parametros)){
                    $tipos=array_shift($parametros);
                    //$params=array_merge([$tipos],$parametros);
                    $statment->bind_param($tipos,...$parametros);
                }

                $resultado=$statment->execute();
                
                if(!$resultado){
                    throw new Exception("Error al ejecutar".$statment->error);
                }

                $statment->close();
                return $this->conexion->error;
            }catch(Exception $error){
                die($error->getMessage());
            }
        }   
    }
?>