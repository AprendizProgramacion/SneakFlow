<?php
namespace Libreria;

spl_autoload_register(function ($clase) {
$rutaArchivo = "../" . str_replace("\\", "/", $clase) . ".php";
//echo  $rutaArchivo . "<br>"; //esta se mirara en el navegador
if (file_exists($rutaArchivo)) require_once $rutaArchivo;
else echo "NO se puede cargar la clase";
});
