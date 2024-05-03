<?php
declare(strict_types=1);


class Color{
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
    static public function getColorById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM COLOR WHERE colorID = ?');
        $stmt->execute(array($id));
        $colorDB = $stmt->fetch(); 

        return new Color(
            intval($colorDB['colorID']),
            $colorDB['name']
        );
    }

    static public function getColorByName(PDO $db, string $name){
        $stmt = $db->prepare('SELECT * FROM COLOR WHERE name = ?');
        $stmt->execute(array($name));
        $colorDB = $stmt->fetch();
        
        return new Color(
            intval($colorDB['colorID']),
            $colorDB['name']
        );
    }

    static public function getAllColors(PDO $db){
        $stmt = $db->prepare('SELECT * FROM COLOR');
        $stmt->execute();
        $colors = array();
        while($colorDB = $stmt->fetch()){
            $color= new Color(intval($colorDB['colorID']),$colorDB['name']);

            $colors[]=$color;
        }

        return $colors;
    }

    static function getColorsOfProduct(PDO $db , int $id){
        $stmt = $db->prepare('SELECT colorID FROM COLORS_OF_PRODUCT WHERE productID = ?');
        $stmt->execute(array($id));
        $colors = array();
        while($colorID=$stmt->fetch()){
            $color = Color::getColorById($db,intval($colorID));
            $colors[] = $color;
        }
        return $colors;
    }
}
?>