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
            intval($imageDB['imageID']),
            $imageDB['path']
        );
    }

    static public function getAllImages(PDO $db){
        $stmt = $db->prepare('SELECT * FROM IMAGES');
        $stmt->execute();
        $images = array();
        while($imageDB = $stmt->fetch()){
            $image= new Image(intval($imageDB['imageID']),$imageDB['path']);

            $images[]=$image;
        }

        return $images;
    }

    static function getImagesOfProduct(PDO $db , int $id){
        $stmt = $db->prepare('SELECT imageID FROM IMAGES_OF_PRODUCT WHERE productID = ?');
        $stmt->execute(array($id));
        $images = array();
        while($imageID=$stmt->fetch()){
            $image = Image::getImageById($db,intval($imageID));
            $images[] = $image;
        }
        return $images;
    }

    static function getImagesPath(PDO $db, int $productID){
        $stmt = $db->prepare('
        SELECT IMAGES.path
        FROM IMAGES JOIN IMAGES_OF_PRODUCT on IMAGES.imageid = IMAGES_OF_PRODUCT.imageid
        WHERE   IMAGES_OF_PRODUCT.productid = ?
        ');
        $stmt->execute(array($productID));
    
        $images = array();
        while($imageDB = $stmt->fetch()){
            $image = $imageDB['path'];
            $images[] = $image;
        }
    
        return $images;
    }
}
?>