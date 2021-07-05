<?php
    class Response { 
        private static $Instancia;
        public static function ObtenerInstancia() : self {
            if(!self::$Instancia instanceof self){
                self::$Instancia = new self();
            }
            return self::$Instancia;
        }
    }
?>