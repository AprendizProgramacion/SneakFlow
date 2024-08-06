<?php
namespace App\Controladores;
class Controlador
{
//atributos
//metodos
public function cargarVista($nomArchivo)
{
require_once "../public/vistas/{$nomArchivo}.php";
}
}
