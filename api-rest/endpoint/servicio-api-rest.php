<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE"); 
    header("Content-Type: application/json");

    include_once '../entidades/cliente.php';
    include_once 'modelo-api-rest.php';

    class Servicioapirest {

        private $Singletoncliente;
        private $Singletonmodelo;
        private static $Instancia;

        function __construct(){
            $this->Singletoncliente = Cliente::ObtenerInstancia();
            $this->Singletonmodelo = Modeloapirest::ObtenerInstancia();
            $this->EjecutarServicioApiRest();
        }

        public static function ObtenerInstancia() : self {
            if(!self::$Instancia instanceof self){
                self::$Instancia = new self();
            }
            return self::$Instancia;
        }

        private function EjecutarServicioApiRest(){ 
            $response;
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $_POST = json_decode(file_get_contents('php://input'));
                    $this->Singletoncliente->SetNombresYApellidos($_POST->Nombresyapellidos);
                    $this->Singletoncliente->SetTipoDeDocumento($_POST->Tipodedocumento); 
                    $this->Singletoncliente->SetNumeroDeDocumento($_POST->Numerodedocumento); 
                    $this->Singletoncliente->SetTelefono($_POST->Telefono); 
                    $this->Singletoncliente->SetEmail($_POST->Email); 
                    $this->Singletoncliente->SetEstado($_POST->Estado); 
                    echo json_encode($this->Singletonmodelo->RegistrarCliente($this->Singletoncliente));
                    break;
                
                case 'GET':
                    echo json_encode($this->Singletonmodelo->ConsultarClientes());
                    break;

                case 'PUT':
                    $_PUT = json_decode(file_get_contents('php://input'));
                    if (isset($_PUT->Numerodedocumento)){
                        $this->Singletoncliente->SetNombresYApellidos($_PUT->Nombresyapellidos);
                        $this->Singletoncliente->SetTipoDeDocumento($_PUT->Tipodedocumento); 
                        $this->Singletoncliente->SetNumeroDeDocumento($_PUT->Numerodedocumento); 
                        $this->Singletoncliente->SetTelefono($_PUT->Telefono); 
                        $this->Singletoncliente->SetEmail($_PUT->Email); 
                        $this->Singletoncliente->SetEstado($_PUT->Estado); 
                        echo json_encode($this->Singletonmodelo->ModificarPropiedadesDeCliente($this->Singletoncliente));
                    } else {
                        $numerodedocumento = $_PUT;
                        echo json_encode($this->Singletonmodelo->ModificarPropiedadeEstado($numerodedocumento));
                    } 
                    break;

                case 'DELETE':
                    $numerodedocumento = $_GET["numerodedocumento"];
                    echo json_encode($this->Singletonmodelo->EliminarCliente($numerodedocumento));
                    break;
            }            
        }
    }
    $Ejecutarservicio = Servicioapirest::ObtenerInstancia();
    $Ejecutarservicio;
?>