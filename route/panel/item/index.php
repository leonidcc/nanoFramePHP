<?php
 class Item  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Item";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model("item")->gets();

         $html .= $this->create("panel/item/read", $data);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function delete($args=[]){
       $id = $args[0];
       $this->model("item")->delete($id );
       header("location:/panel/item");
    }
}

?>
