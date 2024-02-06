<?php
 class Categoria  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Categoria";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model("categoria")->gets();

         $html .= $this->create("panel/categoria/read", $data);
         $html .= $this->create("panel/categoria/create");
         
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function delete($args=[]){
       $id = $args[0];
       $this->model("categoria")->delete($id );
       header("location:/panel/categoria");
    }
}

?>
