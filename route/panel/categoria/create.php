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

         $html .= $this->create("categoria/create");

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function add($value=""){
       $this->model("categoria")->create(
           // $_POST["id_user"],
           $this->sessionUser()->id,
           $_POST["name"],
           $_POST["description"]
        );
       header("location:/panel/categoria");
     }
}
?>
