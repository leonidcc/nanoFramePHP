<?php

class Model_Item{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){
        $qry = "SELECT * FROM `item`   WHERE id = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets(){
        $qry = "SELECT * FROM `item` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }

    public function getsByUser($id){
        $qry = "SELECT * FROM  `item`  WHERE id_user = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

    public function create($name, $description, $img, $price, $id_user, $id_categ){
        $qry = "INSERT INTO `item` (`name`,`description`,`img`,`price`,`id_user`,`id_categ`)
                VALUES (?,?,?,?,?,?)"; 
        $data  = $this->db->consult($qry, [$name, $description, $img, $price, $id_user, $id_categ]);
        return $data;
    }
    public function update($name, $description, $img, $price, $id_user, $id_categ, $id){
        $qry = "UPDATE `item` SET  `name` = ?, `description` = ?, `img` = ?, `price` = ?, `id_user` = ?, `id_categ` = ?   WHERE id = ?";
        $data  = $this->db->consult($qry, [$name, $description, $img, $price, $id_user, $id_categ, $id]);
        return $data;
    }
    public function delete($id){
        $qry = "DELETE FROM `item` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

}

?>
