<?php
include 'helper.class.php';
include 'lib.class.php';
include 'cmp.class.php';


$db = new DB( DB_HOST, DB_NAME,  DB_USER,  DB_PASS );
$contextGlobal = null;

/**
 *
 */

class Context {
  private $css = [];
  private $js = [];

  private $csscmp = "";
  private $jscmp = "";

  public $title;

  // public $db = $GLOBALS["db"];
  function __construct(){
    session_start();
    $this->db = $GLOBALS["db"];
    $GLOBALS["contextGlobal"] = $this;
  }

  // permite invocar funciones definidas en la clase Helper
  public function help($name, $args){
    $obj = new Helper();
    return $obj->$name(...$args);
  }

  // retorna las funcionalidades de una libreria del nucleo
  function lib($libName){
    require_once("core/lib/".$libName.".php");
    $lib = ucfirst($libName);
    $lib = new $lib();
    return $lib;
  }

  // permite hacer uso de las funcionalidades de un modelo
  function model($modelName){
      require_once("modelos/".$modelName.".php");
      $model = "Model_".ucfirst($modelName);
      $model = new $model($this->db);
      return $model;
  }

  // permite crear vistas typo componente o tres archivos
   function create($name, $arg = []) {
       if (file_exists("vistas/".$name."/index.html")) {
           $html= new template("vistas/".$name."/index.html" , $arg);
           $this->css[] = $name;
           $this->js[] = $name;
           return $html;
       }
       else {
           $obj =  new Cmp();
           [$html, $css, $js] = $obj->parseComponent($name,$arg);
           $this->csscmp.=$css;
           $this->jscmp.=$js;
           return $html;
       }
  }


  // retornos para el render HTML o JSON
  function ret( $html) {
     return [
         "type" => "html",
         "title" => $this->title,
         "css" => $this->css,
         "html" => $html,
         "js" => $this->js,
         "bundlecss" => "<style type='text/css'>$this->csscmp</style>",
         "bundlejs" => "<script type='text/javascript'>$this->jscmp</script>"
     ];
  }

  function ok($data, $mensaje = null) {
       http_response_code(200);
       return [
         "error" => false,
         "mensaje" => $mensaje,
         "data" => $data,
       ];
  }

  function error($code, $mensaje) {
      http_response_code($code);
      return [
        "error"=> true,
        "code"=> $code,
        "mensaje"=> $mensaje,
        "data" => null
      ];
  }

  // Sessiones
  function sessionStart($idUser){
      $_SESSION['userId'] = $idUser;
  }
  function sessionFinish(){
      unset($_SESSION['userId']);
  }
  function sessionUser(){
      $user = $this->model("user")->get($_SESSION['userId']);
      if($user != []) return $user[0];
      return null;
  }
  function sessionExist(){
    return isset($_SESSION['userId']);
  }

  function sessionUserIs($rol){
    $user = $this->model("user")->get($_SESSION['userId']);
    if($user != []){
      $roles = explode(" ", $user[0]->rol);
      return in_array("ROL_".$rol,$roles);
    }
    return false;
  }
}

?>
