<?php
  /**
   * Página principal
   */
  class Home extends Context {

    function __construct(){
      // code...
    }

    public function index($arg = []){
      return "Home index World";
    }

    public function create($arg = []){
      return "create index World";
    }
  }

 ?>
