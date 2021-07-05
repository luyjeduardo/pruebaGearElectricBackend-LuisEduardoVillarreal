<?php
    class Conexion {
        
        private static $Instancia;
        private $Host;
        private $Nombredebasededatos;
        private $Usuario;
        private $Contrasenia;

        function __construct()
        {
            $this->Host = 'localhost';
            $this->Nombredebasededatos = 'pruebadedesarrollo';
            $this->Usuario = 'root';
            $this->Contrasenia = '';
        }

        public static function ObtenerInstancia() : self {
            if (!self::$Instancia instanceof self) {
                self::$Instancia = new self();
            }
            return self::$Instancia;
        }

        public function Conectar() {
            try{
                $conexionporpdo = new PDO('mysql: host=' . $this->Host . '; dbname=' . $this->Nombredebasededatos, $this->Usuario, $this->Contrasenia);
                $conexionporpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conexionporpdo;
            }catch(PDOException $e){
                return "error";
            }
        }  
    }
?>