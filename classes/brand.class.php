<?php
declare(strict_types=1);


class Brand{
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
    static public function getBrandById(PDO $db, int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM BRAND WHERE brandID = ?');
            $stmt->execute(array($id));
            $brandDB = $stmt->fetch(); 

            return new Brand(
                intval($brandDB['brandID']),
                $brandDB['name']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getBrandByName(PDO $db, string $name){
        try{
            $stmt = $db->prepare('SELECT * FROM BRAND WHERE name = ?');
            $stmt->execute(array($name));
            $brandDB = $stmt->fetch();
            
            return new Brand(
                intval($brandDB['brandID']),
                $brandDB['name']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getAllBrands(PDO $db){
        try{
            $stmt = $db->prepare('SELECT * FROM BRAND');
            $stmt->execute();
            $brands = array();
            while($brandDB = $stmt->fetch()){
                $brand= new Brand(intval($brandDB['brandID']),$brandDB['name']);

                $brands[]=$brand;
            }

            return $brands;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>