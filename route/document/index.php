<?php
 class Document  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Document";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html  .= $this->create("document");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
