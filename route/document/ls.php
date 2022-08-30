<?php
 class Ls  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "file";
     }

     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         // hace uso de la libreria core/lib/file
         // para listar los archivos en el directorio
         $html  .= $this->lib("files")->ls("@recursos/icons");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
