<?php
include 'config.php';
include 'core/conexion.class.php';
include 'core/context.class.php';
include 'core/template.class.php';
include 'core/utils.function.php';

$uri  = ($_SERVER['REQUEST_URI'] == "/")? "/home": $_SERVER['REQUEST_URI'];
$uriP = explode('?',$uri)[0];
$uriP = array_filter(explode('/',$uriP));
$uriP = array_values($uriP);

$path = DIR_ROUTES;
$i = 0;
for (; $i <  count($uriP) ; $i++){
  if(
    file_exists($path."/".$uriP[$i]) ||
    file_exists($path."/".$uriP[$i].".php")
  ){
     $path .= "/".$uriP[$i];
  } else break;
} $args = array_slice($uriP, $i);

if(isset($args[0]) && file_exists($path."/".$args[0].".php")){
  error_log(">SDSD");
  render($path."/".$args[0], array_slice($args, 1));
}
else if(file_exists($path."/index.php")){
  error_log( $path."/index.php" );
  render($path."/index", $args);
}
else if(file_exists($path.".php")){ 
  render($path, $args);
}
else header("location:/error404");


function render($file, $arg){
  // Archivo php para interpretar
  require_once($file.".php");

  // Página para mostrar
  $explode = explode('/',$file);
  $pg = ucfirst(array_pop($explode));

  // Get class page a partir de la ruta file
  if($pg == "Index"){
    $t = explode('/',$file);
    $pg= ucfirst($t[count($t)-2]);
  }$pg = new $pg();

  // Si el primer argumento  es un método
  if(isset($arg[0])){
    if (method_exists($pg,$arg[0])){
          $f = $arg[0]; array_shift($arg);
          draw($pg->$f($arg));
      }
      else{
            if($uriP)
              array_shift($uriP);
            draw( $pg->index($arg));
        };
  }else draw($pg->index());
}

// pinta al web completa sea un JSON o HTML
function draw($vista){
    switch ($vista["type"]) {
        case 'html':
                extract($vista); // crea las varibales a partir del clave valor
                $view =  new Template("vistas/app.html",[
                    "title"   => $title,
                    "RootCSS"   => $css,
                    "RootHTML" => $html,
                    "RootJS" => $js,
                    "bundleJS" => $bundlejs,
                    "bundleCSS" => $bundlecss
                ]);
                echo $view;
            break;
        default:
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == "OPTIONS") {
            	die();
            }
            header('Content-Type: application/json; charset=utf-8');
            echo(json_encode($vista));
            break;
    }
}
?>
