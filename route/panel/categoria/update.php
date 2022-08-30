<?php
 class Update  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "Inicio";
     }
     public function index($args = []){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model(categoria)->get($args[0]);
         $html .= $this->create("categoria/update", $data[0]);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }
     public function put($arg = []){
       $this->model("categoria")->update(
           // $_POST["id_user"],
           $this->sessionUser()->id,
           $_POST["name"],
           $_POST["description"],
          $_POST["id"]
        );
         header("location:/panel/categoria");
    }
}

?>
