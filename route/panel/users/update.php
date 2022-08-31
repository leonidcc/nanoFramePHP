<?php
 class Update  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "users";
     }
     public function index($args = []){
         // Si no es admin se lo redirige a el panel
        if(!$this->sessionUserIs("ADMIN")) header("location:/panel");

        $usuario = $this->model("users")->get($args[0])[0]; 
        // Si no existe el usuario redireciona al panel
        if(!$usuario) header("location:/panel");

         $html  = $this->create("cmp/navLog");

         $data = $this->model("users")->get($args[0]);

         $html .= $this->create("panel/users/update", $data[0]);

         // $html .= $this->create("panel/users/update",[
         //   "data" => $data[0],
         //   "categorias" => $this->model("categoria")->gets()
         //   ]
         // );

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }
     public function put($arg = []){
       $this->model("users")->update(
         $_POST["name"],
           $_POST["password"],
           $_POST["email"],
           $_POST["rol"],
           $_POST["status"],
           $_POST["phone"],
           $_POST["fecha_registro"],
          $_POST["id"]
        );
         header("location:/panel/users");
    }
}

?>
