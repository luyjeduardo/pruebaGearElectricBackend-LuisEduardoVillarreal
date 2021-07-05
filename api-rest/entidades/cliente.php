<?php
    class Cliente {
        private $Nombresyapellidos;
        private $Tipodedocumento;
        private $Numerodedocumento;
        private $Telefono;
        private $Email;
        private $Estado;

        private static $Instancia;
        public static function ObtenerInstancia() : self {
            if(!self::$Instancia instanceof self){
                self::$Instancia = new self();
            }
            return self::$Instancia;
        }
        
        public function SetNombresYApellidos($nombresyapellidos){ $this->Nombresyapellidos = $nombresyapellidos; }
        public function GetNombresYApellidos(): string{ return $this->Nombresyapellidos; }
        public function SetTipoDeDocumento($tipodedocumento){ $this->Tipodedocumento = $tipodedocumento; }
        public function GetTipoDeDocumento(): string{ return $this->Tipodedocumento; }
        public function SetNumeroDeDocumento($numerodedocumento){ $this->Numerodedocumento = $numerodedocumento; }
        public function GetNumeroDeDocumento(): string{ return $this->Numerodedocumento; }
        public function SetTelefono($telefono){ $this->Telefono = $telefono; }
        public function GetTelefono(): string{ return $this->Telefono; }
        public function SetEmail($email){ $this->Email = $email; }
        public function GetEmail(): string{ return $this->Email; }
        public function SetEstado($estado){ $this->Estado = $estado; }
        public function GetEstado(): string{ return $this->Estado; }
    }
?>