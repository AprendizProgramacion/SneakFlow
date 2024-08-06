<?php
    use App\Controladores\InicioControlador;
    use Libreria\Enrutador;
    //modificado, ahora pasamos la ruta y un array(clase controlador,el metodo)

    Enrutador::get("/", [InicioControlador::class, "inicio"]); //primera ruta ourl
    Enrutador::get("/categorias", function () { //segunda ruta o url
    return "Ruta get de categorias";
    });
    Enrutador::get("/productos", function () { //tercera ruta o url
    return "Ruta get de productos";
        });
        Enrutador::get("/productos/:miVar", function () { //cuarta ruta o url
    return "Ruta get de productos con variable : televisores ";
        });
        Enrutador::obtenerRuta();
        
