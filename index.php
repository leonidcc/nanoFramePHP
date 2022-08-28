<?php
include 'config.php';
include 'core/context.php';

$uri  = ($_SERVER['REQUEST_URI'] == "/")? "/home": $_SERVER['REQUEST_URI'];
$uriP = explode('?',$uri)[0];
$uriP = array_filter(explode('/',$uriP));
$uriP = array_values($uriP);

$path = $DIR_ROUTES;
$i = 0;
for (; $i <  count($uriP) ; $i++){
  if(
    file_exists($path."/".$uriP[$i]) ||
    file_exists($path."/".$uriP[$i].".php")
  ){
     $path .= "/".$uriP[$i];
  } else break;
} $args = array_slice($uriP, $i);

if($args[0] && file_exists($path."/".$args[0].".php")){
  render($path."/".$args[0], array_slice($args, 1));
}
elseif(file_exists($path."/index.php")){
  render($path."/index", $args);
}
elseif(file_exists($path.".php")){
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
            array_shift($uriP);
            draw( $pg->index($arg));
        };
  }else draw($pg->index());
}


function draw($vista){
  echo $vista;
}
?>
