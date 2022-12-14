<?php
 class Create  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Categoria";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html .= $this->create("panel/categoria/create");

         // $html .= $this->create("panel/categoria/create",[
         //   "categorias" => $this->model("categoria")->gets()
         // ]);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function add($value=""){
       $this->model("categoria")->create(
           $this->sessionUser()->id,
           $_POST["name"],
           $_POST["description"]
        );
       header("location:/panel/categoria");
     }
}
?>