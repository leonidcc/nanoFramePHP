<?php
 class Panel  extends Context {
     function __construct( ){
       parent::__construct();
         $this->title = "Panel";
         if(!$this->sessionExist()){
             header("location:/");
             die();
         }
     }
     public function index(){
         $usuario = $this->sessionUser();
         $html  = $this->create("cmp/navLog");

         $html  .= $this->create("panel/general",[
           "userName" => $this->sessionUser()->name,
           "cards" => $this->getGeneralCard()
         ]);
         $html  .= $this->create("panel/crud",[
           "userName" => $this->sessionUser()->name
         ]);
         if($this->sessionUserIs("ADMIN")){
           $html  .= $this->create("panel/administrador",[
             "userName" => $this->sessionUser()->name
           ]);
         }
         $html .= $this->create("cmp/aside");
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     private function getGeneralCard()  {
       return [
             [
                 "img" => "@recursos/icons/user.svg",
                 "title" => "Mis datos",
                 "url" => "/panel/my",
                 "bg"=> "#0273F5",
                 "detail"=> "Información de la cuenta y datos personales"

            ],
             [
                 "img" => "@recursos/icons/cuenta.svg",
                 "title" => "Cuenta",
                 "url" => "#",
                 "bg"=> "#FEC514",
                 "detail"=> "Información de la cuenta y datos personales"

            ],
             [
                 "img" => "@recursos/icons/config.svg",
                 "title" => "Configuración",
                 "url" => "#",
                 "bg"=> "#F04E98",
                 "detail"=> "Información de la cuenta y datos personales"

            ],
             [
                 "img" => "@recursos/icons/proba.svg",
                 "title" => "Mi web",
                 "url" => "#",
                 "bg"=> "#00BFB3",
                 "detail"=> "Información de la cuenta y datos personales"

            ],
        ];
     } 
}

?>
