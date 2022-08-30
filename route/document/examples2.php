<?php
 class Examples2  extends Context {
     function __construct(){
         parent::__construct();
         $this->title = "About";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");
         $html  .= $this->create("_pro/main1",[
           "title"=>"#LOREM SET TITLE SET",
           "parrafo"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod ",
           "url"=> "#",
           "text" => "Leer mas"
         ]);
         $html  .= $this->create("_pro/main2",[
           "title"=>"#LOREM SET TITLE SET",
           "parrafo"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod ",
           "url"=> "#",
           "text" => "SABER MÁS SOBRE LOREM SET "
         ]);
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
