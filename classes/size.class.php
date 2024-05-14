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

    //queries
    static public function getSizeById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM SIZE WHERE sizeID = ?');
        $stmt->execute(array($id));
        $sizeDB = $stmt->fetch(); 

        return new Size(
            intval($sizeDB['sizeID']),
            $sizeDB['name']
        );
    }

    static public function getSizeByName(PDO $db, string $name){
        $stmt = $db->prepare('SELECT * FROM SIZE WHERE name = ?');
        $stmt->execute(array($name));
        $sizeDB = $stmt->fetch();
        
        return new Size(
            intval($sizeDB['sizeID']),
            $sizeDB['name']
        );
    }

    static public function getAllSizes(PDO $db){
        $stmt = $db->prepare('SELECT * FROM SIZE');
        $stmt->execute();
        $sizes = array();
        while($sizeDB = $stmt->fetch()){
            $size= new Size(intval($sizeDB['sizeID']),$sizeDB['name']);

            $sizes[]=$size;
        }

        return $sizes;
    }

    static function getSizesOfProduct(PDO $db , int $id){
        $stmt = $db->prepare('SELECT sizeID FROM SIZE_OF_PRODUCT WHERE productID = ?');
        $stmt->execute(array($id));
        $sizes = array();
        while($sizeID = $stmt->fetch()){
            $size = Size::getSizeById($db,intval($sizeID['sizeID']));
            $sizes[] = $size;
        }
        return $sizes;
    }
}
?>