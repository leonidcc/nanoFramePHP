<?php
 class  Login extends Context {
     function __construct( ){
       parent::__construct();
         $this->title = "Login";
          if($this->sessionExist()) header("location:/admin");
     }

     public function index($arg = null){
         $html  = $this->create("cmp/nav");
         $html  .= $this->create("log/in");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

      public function iniciar_session($arg = null){

          $data = $this->model("users")->getByEmail($_POST["email"]);

          if(count($data) > 0){
               if(password_verify($_POST["password"], $data[0]->password)){
                   $this->sessionStart($_POST["email"]);
                   return $this->ok($_POST["email"],"Correctamente");
               }
               else $msj =  "Verifique la contraseña";
          }
          else $msj =  "El usuario no existe";
          return $this->error(200,$msj);
      }

      public function cerrar_session(){
          $this->sessionFinish();
          header("location:/login");
      }
 }

?>
