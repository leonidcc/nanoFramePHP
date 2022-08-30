<?php

class Model_Categoria{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){
        $qry = "SELECT * FROM `categoria`   WHERE id = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets(){
        $qry = "SELECT * FROM `categoria` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }

    public function getsByUser($id){
        $qry = "SELECT * FROM  `categoria`  WHERE id_user = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function create($id_user, $name, $description){
        $qry = "INSERT INTO `categoria` (`id_user`,`name`,`description`)
                VALUES (?,?,?)";
        $data  = $this->db->consult($qry, [$id_user, $name, $description]);
        return $data;
    }
    public function update($id_user, $name, $description, $id){
        $qry = "UPDATE `categoria` SET  `id_user` = ?, `name` = ?, `description` = ?   WHERE id = ?";
        $data  = $this->db->consult($qry, [$id_user, $name, $description, $id]);
        return $data;
    }
    public function delete($id){
        $qry = "DELETE FROM `categoria` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

}

?>
