<?php
  /**
   * Página  Example API
   */
  class Api extends Context {

    function __construct(){
      parent::__construct();
      $this->title = "Pedido";
    }
    public function index($arg = [  ]){ 
      return $this->ok($arg);
    }
  }

 ?>
