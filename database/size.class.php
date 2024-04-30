<?php
declare(strict_types=1);


class Size{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name){
        $this->id= $id;
        $this->name= $name;

    }


    //getters
    public function getId() : int{
        return $this->id;
    }

    public function getName() : string{
        return $this->name;
    }

    //querys
    static public function getSizeById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM SIZE WHERE id = ?');
        $stmt->execute(array($id));
        $sizeDB = $stmt->fetch(); 

        return new Size(
            intval($sizeDB['id']),
            $sizeDB['name']
        );
    }

    static public function getSizeByName(PDO $db, string $name){
        $stmt = $db->prepare('SELECT * FROM SIZE WHERE name = ?');
        $stmt->execute(array($name));
        $sizeDB = $stmt->fetch();
        
        return new Size(
            intval($sizeDB['id']),
            $sizeDB['name']
        );
    }

    static public function getAllSizes(PDO $db){
        $stmt = $db->prepare('SELECT * FROM SIZE');
        $stmt->execute();
        $sizes = array();
        while($sizeDB = $stmt->fetch()){
            $size= new Size(intval($sizeDB['id']),$sizeDB['name']);

            $sizes[]=$size;
        }

        return $sizes;
    }
}
?>