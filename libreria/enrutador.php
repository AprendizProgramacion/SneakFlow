<?php
namespace Libreria;
use App\Controladores\InicioControlador;
class Enrutador
    {
    //atributos
    private static $rutas = [];
    //metodo para agregar rutas tipo get
    public static function get($url, $llamarFuncion)
    {
    $url = trim($url, "/");
    self::$rutas["GET"][$url] = $llamarFuncion;
    }
    //metodo para agregar rutas tipo post
    public static function post($url, $llamarFuncion)
    {
    $url = trim($url, "/");
    self::$rutas["POST"][$url] = $llamarFuncion;
    }
    //metodo para ver las rutas que se almacenaron en el atributo rutas quees array.
    public static function obtenerRuta()
    {
    $metodo = $_SERVER["REQUEST_METHOD"];
    $uri = $_SERVER["REQUEST_URI"];
    $posicionPublic = strpos($uri, "public");
    //borramos los slash al inicio al final de la ruta y extraemos rutadespues de la palabra public.
    $uri = trim(substr($uri, $posicionPublic + 6), "/");
    foreach (self::$rutas[$metodo] as $ruta => $funcionCall) {
    $uri = trim($uri, "/");
    //si hay ':' en la ruta, modificar la ruta asi:
    if (strpos($ruta, ":")) {
    //la ruta ahora tiene un subpatron, que sera comparado conla uri en la otra linea
    $ruta = preg_replace("#:[a-zA-Z0-9]+#", "([a-zA-Z0-9]+)",
    $ruta);
    }
    //valida la expresion-regular con la uri
    if (preg_match("%^$ruta$%", $uri, $coindiceRutaUri)) {
    //creamos otro array desde el otro arreglo pero desde elinidce 1, por si enviamos mas variable por la url
    $misVariablesUrl = array_slice($coindiceRutaUri, 1);
    //comprobar si lo que se envio de rutasWeb ($funcionCall) esuna funcion, o es array(clase controlador,el metodo)
    if (is_callable($funcionCall)) {
    $funcionCall(...$misVariablesUrl); //enviamos todo elarray(misVariablesUrl), y en rutasWeb recibirlo
    } else {
    //es array, entonces -> instanciar la claseInicioControlador
    //$controlador = new InicioControlador();
    //$controlador->inicio();
    $controlador = new $funcionCall[0];
    $controlador->{$funcionCall[1]}(...$misVariablesUrl);
    }
    return;
    }
    }
    echo "No existe la pagina web. Error 404<br>";
    }
    }


