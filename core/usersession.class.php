<?php
/**
 *
 */
class UserSession{
    function __construct(){
      session_start();
    }
    public function start($idUser){
      $_SESSION['userId'] = $idUser;
    }
    public function finish($idUser){
      $_SESSION['userId'] = $idUser;
    }
    public function user($idUser){
      $_SESSION['userId'] = $idUser;
    }
}


 ?>
