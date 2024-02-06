<?php
 class Examples  extends Context {
     function __construct(){
         parent::__construct();
         $this->title = "About";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html  .= $this->create("/document/examples");       
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }



}

?>
