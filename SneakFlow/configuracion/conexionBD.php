<?php 
    // configuracion/conexionBD.php
    define('BASE_URL', 'http://localhost/SneakFlow/');
    class ConexionBD {
        private $host = 'localhost';
        private $dbname = 'sneakflow';
        private $username = 'root';
        private $password = '';
        private $conexion;
        

        public function __construct() {
            $this->conexion = new mysqli($this->host, $this->username, $this->password, $this->dbname);

            // Verificar si la conexión fue exitosa
            if ($this->conexion->connect_error) {
                throw new Exception("Error de conexión: " . $this->conexion->connect_error);
            }
        }

        public function getConnection() {
            return $this->conexion;
        }

        public function close() {
            if ($this->conexion) {
                $this->conexion->close();
            }
        }
    }
?>
