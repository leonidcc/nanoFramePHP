<?php
 class Error404  extends Context {
   function __construct(){
     parent::__construct();
     $this->title = "404";
   }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");
         $html  .= $this->create("error404");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
