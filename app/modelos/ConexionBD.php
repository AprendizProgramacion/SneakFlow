<?php
namespace App\Modelos;
use mysqli;

    class ConexionBD
    {
    //atributos
    private $servidor = BD_SERVIDOR;
    private $usuario = BD_USUARIO;
    private $clave = BD_CLAVE;
    private $bd = BD_NOMBRE;
    private $conexion;
    //metodos
    public function __construct()
    {
    $this->conectarse();
    }
    public function conectarse()
    {
    //mejora utilizar try catch
    $this->conexion = new mysqli($this->servidor, $this->usuario, $this->clave, $this->bd);
    echo !$this->conexion->error ? "Conexion a BD exitosa!!!" : "Error
    de conexion a BD";
    }
    public function desconectarse()
    {
    $this->conexion->close();
    unset($this->conexion);
    }
    }
