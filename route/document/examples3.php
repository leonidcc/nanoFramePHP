<?php
 class Examples3  extends Context {
     function __construct(){
         parent::__construct();
         $this->title = "About";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html  .= $this->create("_pro/banner" );
         $html  .= $this->create("_pro/form" );
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
