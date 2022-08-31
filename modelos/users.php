<?php

class Model_Users{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){
        $qry = "SELECT * FROM `users`   WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function getByEmail($email){
        $qry = "SELECT * FROM `users`   WHERE email = ?";
        $data  = $this->db->consult($qry, [$email]);
        return $data;
    }
    public function getsByUser($id){
        $qry = "SELECT * FROM `users`  WHERE id_user = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets(){
        $qry = "SELECT * FROM `users` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }
    public function registro($name, $password, $email, $phone)  {
        $qry = "INSERT INTO `users`
            (`id`, `name`, `password`, `email`, `rol`, `phone`, `fecha_registro`, `status`)
            VALUES (DEFAULT,?,?,?,'ROL_USER',?, NOW(),0)";
        $this->db->consult($qry,[$name, $password,$email, $phone]);
    }
    public function create($name, $password, $email, $rol, $status, $phone, $fecha_registro){
        $qry = "INSERT INTO `users` (`name`,`password`,`email`,`rol`,`status`,`phone`,`fecha_registro`)
                VALUES (?,?,?,?,?,?,NOW())";
        $data  = $this->db->consult($qry, [$name, $password, $email, $rol, $status, $phone]);
        return $data;
    }
    public function update($name, $password, $email, $rol, $status, $phone, $fecha_registro, $id){
        $qry = "UPDATE `users` SET  `name` = ?,     `status` = ?, `phone` = ?   WHERE id = ?";
        $data  = $this->db->consult($qry, [$name,      $status, $phone,   $id]);
        return $data;
    }
    public function updatemy($phone, $name, $id)  {
        $qry = "UPDATE `users` SET  `phone` = ?,  `name` = ? WHERE `id` = ? ";
        $this->db->consult($qry,[$phone, $name, $id]);
    }
    public function delete($id){
        $qry = "DELETE FROM `users` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function active($id)  {
        $statusOld = $this->get($id)[0]->status;
        $qry = "UPDATE `users` SET  `status` = ?  WHERE `id` = ? ";
        $this->db->consult($qry,[($statusOld)?'0':'1' ,$id]);
    }

    public function exist($id)  {
        return count($this->getByEmail($id)) > 0;
    }

    public function setRol($rol, $id) {
        $qry = "UPDATE `users` SET  `rol` = ?  WHERE `id` = ? ";
        $this->db->consult($qry,[$rol, $id]);
    }

}

?>
