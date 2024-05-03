<?php
declare(strict_types=1);


class Image{
    private int $id;
    private string $path;
    

    public function __construct(int $id, string $path){
        $this->id= $id;
        $this->path= $path;
        

    }


    //getters
    public function getId() : int{
        return $this->id;
    }

    public function getPath() : string{
        return $this->path;
    }

    

    //querys
    static public function getImageById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE imageID = ?');
        $stmt->execute(array($id));
        $imageDB = $stmt->fetch(); 

        return new Image(
            intval($conditionDB['imageID']),
            $conditionDB['path']
        );
    }

    static public function getAllImages(PDO $db){
        $stmt = $db->prepare('SELECT * FROM IMAGES');
        $stmt->execute();
        $images = array();
        while($imageDB = $stmt->fetch()){
            $image= new Image(intval($conditionDB['imageID']),$conditionDB['path']);

            $images[]=$image;
        }

        return $images;
    }

    static function getImagesOfProduct(PDO $db , int $id){
        $stmt = $db->prepare('SELECT conditionID FROM IMAGES_OF_PRODUCT WHERE productID = ?');
        $stmt->execute(array($id));
        $images = array();
        while($imageID=$stmt->fetch()){
            $image = Image::getConditionById($db,intval($imageID));
            $images[] = $image;
        }
        return $images;
    }
}
?>