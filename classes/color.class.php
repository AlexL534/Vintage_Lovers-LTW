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

    //queries
    static public function getColorById(PDO $db, int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM COLOR WHERE colorID = ?');
            $stmt->execute(array($id));
            $colorDB = $stmt->fetch(); 

            return new Color(
                intval($colorDB['colorID']),
                $colorDB['name']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getColorByName(PDO $db, string $name){
        try{
            $stmt = $db->prepare('SELECT * FROM COLOR WHERE name = ?');
            $stmt->execute(array($name));
            $colorDB = $stmt->fetch();
            
            return new Color(
                intval($colorDB['colorID']),
                $colorDB['name']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getAllColors(PDO $db){
        try{
            $stmt = $db->prepare('SELECT * FROM COLOR');
            $stmt->execute();
            $colors = array();
            while($colorDB = $stmt->fetch()){
                $color= new Color(intval($colorDB['colorID']),$colorDB['name']);

                $colors[]=$color;
            }

            return $colors;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function getColorsOfProduct(PDO $db , int $id){
        try{
            $stmt = $db->prepare('SELECT colorID FROM COLORS_OF_PRODUCT WHERE productID = ?');
            $stmt->execute(array($id));
            $colors = array();
            while($colorID=$stmt->fetch()){
                $color = Color::getColorById($db,intval($colorID['colorID']));
                $colors[] = $color;
            }
            return $colors;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function insertColorOfProduct(PDO $db , int $idProduct, int $idColor){
        try{
            $stmt = $db->prepare('INSERT INTO COLORS_OF_PRODUCT (colorID, productID) VALUES (?, ?)');
            $stmt->execute(array($idColor, $idProduct));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function deleteColorOfProduct(PDO $db , int $idProduct){
        try{
            $stmt = $db->prepare('Delete from COLORS_OF_PRODUCT where productID = ?');
            $stmt->execute(array($idProduct));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>