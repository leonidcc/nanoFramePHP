<?php
 class User  extends Context {
     function __construct(){
       parent::__construct();
         $this->title = "Inicio";
         if(!$this->sessionExist()) header("location:/");
         if(!$this->sessionUserIs("ADMIN")) header("location:/admin");
     }
     public function index(){
         $usuarios = $this->model("user")->gets();

         $html  = $this->create("cmp/navLog");
         $html  .= $this->create("cmp/title",[
             "title" => "Usuarios"
         ]);
         $html  .=  $this->create("panel/user/read", [
                   "usuarios" => $usuarios
         ]);
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function update( $arg=[] ){
          // Si no es admin se lo redirige a el panel
         if(!$this->sessionUserIs("ADMIN")) header("location:/panel");

         $usuario = $this->model("user")->getById($arg[0])[0];

         // Si no existe el usuario redireciona al panel
         if(!$usuario) header("location:/panel");

         $html  = $this->create("cmp/navLog");
         $html  .= $this->create("cmp/title",[
             "title" => "Usuarios"
         ]);
         $html  .=  $this->create("panel/user/update", [
                        "usuario" => $usuario
         ]);
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     function active($id){
          if($this->sessionUserIs("ADMIN")){
              $this->model("user")->active($id[0]);
          }

          header("location:/panel/user");
     }

     function add_rol(){
          if($this->sessionUserIs("ADMIN")){
              $usuario = $this->model("user")->getById($_POST["id"])[0];
              if($_POST["rol"] != ""){
                $this->model("user")->setRol(
                  mb_strtoupper($usuario->rol." ROL_".$_POST["rol"]),
                  $_POST["id"]
                );
            }
          }
          header("location:/panel/user/update/".$_POST["id"]);
     }
     function rm_rol($arg = []){
          $usuario = $this->model("user")->getById($arg[0])[0];

          // Si no existe el usuario redireciona al panel
          if(!$usuario) header("location:/panel");

          $newRol = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], str_replace($arg[1],"", $usuario->rol));
          if($this->sessionUserIs("ADMIN")){
              $this->model("user")->setRol(
                $newRol,
                $arg[0]
              );
          }
          header("location:/panel/user/update/".$arg[0]);
     }
}

?>
