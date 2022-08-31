<?php
 class Create  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Users";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html .= $this->create("panel/users/create");

         // $html .= $this->create("panel/users/create",[
         //   "categorias" => $this->model("categoria")->gets()
         // ]);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function add($value=""){
       $this->model("users")->create(
           $_POST["name"],
           $_POST["password"],
           $_POST["email"],
           $_POST["rol"],
           $_POST["status"],
           $_POST["phone"],
           $_POST["fecha_registro"]
        );
       header("location:/panel/users");
     }
}
?>