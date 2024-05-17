<?php
declare(strict_types=1);


class Category{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(int $id, string $name, string $description){
        $this->id= $id;
        $this->name= $name;
        $this->description=$description;

    }


    //getters
    public function getId() : int{
        return $this->id;
    }

    public function getName() : string{
        return $this->name;
    }

    public function getDescription() : string{
        return $this->description;
    }

    //queries
    static public function getCategoryById(PDO $db, int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE categoryID = ?');
            $stmt->execute(array($id));
            $categoryDB = $stmt->fetch(); 

            return new Category(
                intval($categoryDB['categoryID']),
                $categoryDB['name'],
                $categoryDB['description']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getCategoryByName(PDO $db, string $name){
        try{
            $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE name = ?');
            $stmt->execute(array($name));
            $categoryDB = $stmt->fetch();
            
            return new Category(
                intval($categoryDB['categoryID']),
                $categoryDB['name'],
                $categoryDB['description']
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getAllCategories(PDO $db){
        try{
            $stmt = $db->prepare('SELECT * FROM CATEGORY');
            $stmt->execute();
            $categories = array();
            while($categoryDB = $stmt->fetch()){
                $category= new Category(intval($categoryDB['categoryID']),$categoryDB['name'],$categoryDB['description']);

                $categories[]=$category;
            }

            return $categories;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getCategoriesLimit(PDO $db, int $limit){
        try{
            $stmt = $db->prepare('SELECT * FROM CATEGORY limit ?');
            $stmt->execute(array($limit));
            $categories = array();
            while($categoryDB = $stmt->fetch()){
                $category= new Category(intval($categoryDB['categoryID']),$categoryDB['name'],$categoryDB['description']);

                $categories[]=$category;
            }

            return $categories;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>