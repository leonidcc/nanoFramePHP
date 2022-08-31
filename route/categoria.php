<?php
 class Categoria  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "categoria";
     }
     public function index($arg = []){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         if(count($arg)){
           $data = $this->model("categoria")->get($arg[0])[0];
           $html .= $this->create("panel/categoria/show",$data);
         }else {
           $data = $this->model("categoria")->gets();
           $html .= $this->create("panel/categoria/index", $data);
         }
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
