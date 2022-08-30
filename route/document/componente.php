<?php
 class Componente  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "file";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

        // Permite usar funciones definidas en helper
        // helper.class.php
        $suma = $this->help("suma",[1, 1]);
        $html  .= $this->create("_cmp/componente",[
          "name" => "SOY UN COMPONENTE DE UN SOLO ARCHIVO y la suma 1 + 1 es $suma"
        ]);
        return $this->ret($html);
     }
}

?>
