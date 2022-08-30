<?php
  /**
   * Página principal
   */
  class Home extends Context {

    function __construct(){
      parent::__construct();
      $this->title = "Inicio";
    }

    public function index($arg = []){
      $html  = ($this->sessionExist())
         ?$this->create("cmp/navLog")
         :$this->create("cmp/nav");
      $html .= $this->create("inicio");
      $html .= $this->create("cmp/footer");
      return $this->ret($html);
    }
  }

 ?> 
