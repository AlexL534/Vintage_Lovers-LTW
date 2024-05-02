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

    //querys
    static public function getCategoryById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE id = ?');
        $stmt->execute(array($id));
        $categoryDB = $stmt->fetch(); 

        return new Category(
            intval($categoryDB['id']),
            $categoryDB['name'],
            $categoryDB['description']
        );
    }

    static public function getCategoryByName(PDO $db, string $name){
        $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE name = ?');
        $stmt->execute(array($name));
        $categoryDB = $stmt->fetch();
        
        return new Category(
            intval($categoryDB['id']),
            $categoryDB['name'],
            $categoryDB['description']
        );
    }

    static public function getAllCategories(PDO $db){
        $stmt = $db->prepare('SELECT * FROM CATEGORY');
        $stmt->execute();
        $categories = array();
        while($categoryDB = $stmt->fetch()){
            $category= new Category(intval($categoryDB['id']),$categoryDB['name'],$categoryDB['description']);

            $categories[]=$category;
        }

        return $categories;
    }
}
?>