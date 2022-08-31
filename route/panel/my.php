<?php
 class My  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Inicio";
         if(!$this->sessionExist()) header("location:/");
     }
     public function index(){
         $us   = $this->sessionUser();
         $html  = $this->create("cmp/navLog");

         $html  .=  $this->create("panel/users/my", [
                 "name" =>$us->name,
                 "email" =>$us->email,
                 "phone" =>$us->phone
         ]);
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }



     public function update( ){
         $usuario   = $this->sessionUser();
         $this->model("users")->updatemy($_POST["tel"], $_POST["name"],$usuario->id);
         header("location:/panel/my");
     }
}

?>
