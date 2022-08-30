<?php
 class Item  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Inicio";
     }
     public function index($arg = []){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         if(count($arg)){
           $data = $this->model("item")->get($arg[0])[0];
           $html .= $this->create("panel/item/show",$data);
         }else {
           $data = $this->model("item")->gets();
           $html .= $this->create("panel/item/index", $data);
         }
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
