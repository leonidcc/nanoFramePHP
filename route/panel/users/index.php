<?php
 class Users  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Users";
         // si no es admin
         if(!$this->sessionUserIs("ADMIN")){
           header("location:/panel");
           die();
         }
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model("users")->gets();

         $html .= $this->create("panel/users/read", $data);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function delete($args=[]){
       // si no es admin
       if(!$this->sessionUserIs("ADMIN")){
         header("location:/panel");
         die();
       }

       if($this->sessionUserIs("ADMIN")){
         $id = $args[0];
         $this->model("users")->delete($id );
       }
       header("location:/panel/users");
    }

    function active($id){
       if($this->sessionUserIs("ADMIN")){
           $this->model("users")->active($id[0]);
       }
       header("location:/panel/users");
    }
    function add_rol(){

       if($this->sessionUserIs("ADMIN")){
           $usuario = $this->model("users")->get($_POST["id"])[0];
           if($_POST["rol"] != ""){
             $this->model("users")->setRol(
              strtoupper($usuario->rol." ROL_".$_POST["rol"]),
               $_POST["id"]
             );
         }
       }
       header("location:/panel/users/update/".$_POST["id"]);
    }
    function rm_rol($arg = []){ 

         $usuario = $this->model("users")->get($arg[0])[0];

         // Si no existe el usuario redireciona al panel
         if(!$usuario) header("location:/panel");

         $newRol = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], str_replace($arg[1],"", $usuario->rol));
         if($this->sessionUserIs("ADMIN")){
             $this->model("users")->setRol(
               $newRol,
               $arg[0]
             );
         }
         header("location:/panel/users/update/".$arg[0]);
    }
}

?>
