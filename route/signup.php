<?php
 class Signup  extends Context {
     function __construct(){
         parent::__construct();
         $this->title = "Registrarse";
         if($this->sessionExist()) header("location:/admin");
     }

     public function index($arg = null){
         $html  = $this->create("cmp/nav");
         $html  .= $this->create("log/up");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function registrarse($arg = null){
          $msj = "";
          if($this->model("users")->exist($_POST["email"]))
          $msj = "El usuario con el email ya existe";
          else{
            $this->model("users")->registro(
              $_POST["name"],
              password_hash( $_POST["pass1"], PASSWORD_DEFAULT),
              $_POST["email"],
              ($_POST["phone"])?$_POST["phone"]:"000"
            );
            $this->sessionStart($_POST["email"]);
            return $this->ok($_POST["email"],"Correctamente");
          }
          return $this->error(200,$msj);
     }

}

?>
