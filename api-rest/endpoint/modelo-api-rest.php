<?php
    include_once '../conexion/conexion.php';
    include_once 'response.php';

    class Modeloapirest {

        private static $Instancia;
        private $Conectar;
        private $Respuestajsoncompleja;

        function __construct(){ }

        public static function ObtenerInstancia() : self {
            if(!self::$Instancia instanceof self){
                self::$Instancia = new self();
            }
            return self::$Instancia;
        }

        private function ValidarConexionALaBaseDeDatos() : bool {
            $this->Conectar = Conexion::ObtenerInstancia();
            if($this->Conectar->Conectar() != "error"){
                return true;
            } else {
                return false;
            }
        }

        #Region-REGISTRO DE CLIENTES...
        public function RegistrarCliente($cliente) : array {
            $response;
            if ($this->ValidarConexionALaBaseDeDatos()){
                if ($this->ValidarDuplicidadDeUsuario($cliente)) {
                    $response["respuesta"] = "error";
                    $response["mensaje"] = "El usuario ya existe en la base de datos";
                } else {
                    $response = $this->RegistrarEnLaBaseDeDatos($cliente);
                }
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Falló la conexión con la base de datos";
            }
            return $response;
        }

        private function ValidarDuplicidadDeUsuario($cliente) : bool{
            $encontrado = FALSE;
            $sentenciasql = "SELECT * FROM clientes WHERE numerodedocumento = '" . $cliente->GetNumeroDeDocumento() . "';";
            $respuesta = $this->Conectar->Conectar()->query($sentenciasql);
            foreach($respuesta as $row) {
                $encontrado = TRUE;    
            }
            if($encontrado){
                return true;                
            } else {
                return false;
            }
        }

        private function RegistrarEnLaBaseDeDatos($cliente) : array{ 
            $response;
            $tipodedocumento = $cliente->GetTipoDeDocumento();
            $numerodedocumento = $cliente->GetNumeroDeDocumento();
            $nombresyapellidos = $cliente->GetNombresYApellidos();            
            $telefono = $cliente->GetTelefono();
            $email = $cliente->GetEmail();
            $estado = $cliente->GetEstado();
            $stmt = $this->Conectar->Conectar()->prepare("INSERT INTO clientes (tipodedocumento, numerodedocumento, nombresyapellidos, telefono, email, estado) 
                VALUES (:tipodedocumento, :numerodedocumento, :nombresyapellidos, :telefono, :email, :estado)");
            $stmt->bindParam(':tipodedocumento', $tipodedocumento, PDO::PARAM_STR, 25);
            $stmt->bindParam(':numerodedocumento', $numerodedocumento, PDO::PARAM_STR, 10);
            $stmt->bindParam(':nombresyapellidos', $nombresyapellidos, PDO::PARAM_STR, 100);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 100);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR, 10);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $response["respuesta"] = "success";
                $response["mensaje"] = "Se registró la información con éxito.";
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Error al registrar en la base de datos.";
            } 
            return $response; 
        }
        #End region-REGISTRO DE CLIENTES.


        #Region-COSULTA DE LOS CLIENTES
        public function ConsultarClientes() {
            if ($this->ValidarConexionALaBaseDeDatos()){
                $response = $this->HacerConsultaALaBaseDeDatos();
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Falló la conexión con la base de datos";
            }
            return $response;
        }

        private function HacerConsultaALaBaseDeDatos() {
            $this->Respuestajsoncompleja = Response::ObtenerInstancia();
            $sentenciasql = "SELECT tipodedocumento, numerodedocumento, nombresyapellidos, telefono, email, estado FROM clientes";
            $respuesta_ = $this->Conectar->Conectar()->query($sentenciasql);
            foreach($respuesta_ as $row) {
                $this->Respuestajsoncompleja->respuesta = 'success';
                $this->Respuestajsoncompleja->clientes[] = $row;
            } 
            return $this->Respuestajsoncompleja;
        }
        #End region-COSULTA DE LOS CLIENTES


        #Region-MODIFICACIÓN DE ESTADO
        public function ModificarPropiedadeEstado($numerodedocumento) : array {
            if ($this->ValidarConexionALaBaseDeDatos()){
                $response = $this->ModificarEstadoEnLaBaseDeDatos($numerodedocumento);
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Falló la conexión con la base de datos";
            }
            return $response;
        }

        private function ModificarEstadoEnLaBaseDeDatos($numerodedocumento) : array {
            $response;
            $estado = "inactivo";
            $stmt = $this->Conectar->Conectar()->prepare(
                "UPDATE clientes SET estado = :estado WHERE numerodedocumento = :numerodedocumento");          
            $stmt->bindParam(':numerodedocumento', $numerodedocumento, PDO::PARAM_STR, 10);         
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR, 10);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $response["respuesta"] = 'success';
                $response["mensaje"] = 'Se inhabilitó el cliente con éxito.';
            } else {
                $response["respuesta"] = 'error';
                $response["mensaje"] = 'Error inesperado con la base de datos. No se pudo inhabilitar el cliente.';
            }     
            return $response;
        }
        #End region-MODIFICACIÓN DE ESTADO


        #Region-MODIFICACIÓN DE PROPIEDADES DE CLIENTE
        public function ModificarPropiedadesDeCliente($cliente) : array{
            $response;
            if ($this->ValidarConexionALaBaseDeDatos()){
                $response = $this->ModificarEnLaBaseDeDatos($cliente);
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Falló la conexión con la base de datos";
            }
            return $response;
        }

        private function ModificarEnLaBaseDeDatos($cliente) : array{ 
            $response;
            $tipodedocumento = $cliente->GetTipoDeDocumento();
            $numerodedocumento = $cliente->GetNumeroDeDocumento();
            $nombresyapellidos = $cliente->GetNombresYApellidos();            
            $telefono = $cliente->GetTelefono();
            $email = $cliente->GetEmail();
            $estado = $cliente->GetEstado();
            $stmt = $this->Conectar->Conectar()->prepare("
                    UPDATE clientes SET tipodedocumento = :tipodedocumento, nombresyapellidos = :nombresyapellidos, telefono = :telefono,
                    email = :email, estado = :estado WHERE numerodedocumento = :numerodedocumento;
                ");
            $stmt->bindParam(':tipodedocumento', $tipodedocumento, PDO::PARAM_STR, 25);
            $stmt->bindParam(':numerodedocumento', $numerodedocumento, PDO::PARAM_STR, 10);
            $stmt->bindParam(':nombresyapellidos', $nombresyapellidos, PDO::PARAM_STR, 100);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 100);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR, 10);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $response["respuesta"] = "success";
                $response["mensaje"] = "Se modificó la información con éxito.";
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Error al modificar en la base de datos.";
            } 
            return $response;     
        }
        #End region-MODIFICACIÓN DE PROPIEDADES DE CLIENTE


        #Region-ELIMINACIÓN DE CLIENTE
        public function EliminarCliente($numerodedocumento) : array {
            $response;
            if ($this->ValidarConexionALaBaseDeDatos()){
                $response = $this->EliminarDeLaBaseDeDatos($numerodedocumento);
            } else {
                $response["respuesta"] = "error";
                $response["mensaje"] = "Falló la conexión con la base de datos";
            }
            return $response;
        }

        private function EliminarDeLaBaseDeDatos($numerodedocumento) : array {
            $response;
            $stmt = $this->Conectar->Conectar()->prepare("DELETE FROM clientes WHERE numerodedocumento = :numerodedocumento");
            $stmt->bindParam(':numerodedocumento', $numerodedocumento);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $response["respuesta"] = 'success';
                $response["mensaje"] = 'Cliente eliminado con éxito.';
            } else {
                $response["respuesta"] = 'error';
                $response["mensaje"] = 'Lo sentimos, pero no se pudo eliminar el cliente de la base de datos.';
            }
            return $response;
        }
        #End region-ELIMINACIÓN DE CLIENTE
    }
?>