<?php
namespace App\Controladores;
class CategoriaControlador extends Controlador
{
//atributos
//metodos
public function inicio()
{

$this->cargarVista("categorias/inicio");
}
public function crear()
{
$this->cargarVista("categorias/crear");
}
public function editar()
{
$this->cargarVista("categorias/editar");
}
public function eliminar()
{
$this->cargarVista("categorias/eliminar");
}
}