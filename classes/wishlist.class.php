<?php

declare(strict_types = 1);
class Wishlist{

    private int $userID;
    private int $productID;

    public function __construct(int $userID, int $productID){
        $this->userID= $userID;
        $this->productID= $productID;

    }

    public function getUserID() : int{
        return $this->userID;
    }

    public function getProductID() : int{
        return $this->productID;
    }

    static function getUserWishlist(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM WISHLIST where userID = ?');
        $stmt->execute(array($id));
        $listItens = array();

        while($listDB = $stmt->fetch()){
            $list = new Wishlist(intval($listDB['userID']), intval($listDB['productID']));
            $listItens[] = $list;
        }

        return $listItens;
    }

    static function isProductInWishlist(PDO $db,int $idUser, int $idProduct){
        $stmt = $db->prepare('SELECT * FROM WISHLIST where productID = ? and userID = ?');
        $stmt->execute(array($idProduct, $idUser));
        $product = $stmt->fetchAll();

        if(empty($product)){
            return false;
        }

        return true;
    }

    static function insertProductInWishlist(PDO $db, int $idUser, int $idProduct){
        $stmt=$db->prepare('INSERT INTO WISHLIST VALUES (?,?)');
        $stmt->execute(array($idUser,$idProduct));
    }

    static function deleteProductInWishlist(PDO $db, int $idUser, int $idProduct){
        $stmt = $db->prepare("DELETE FROM WISHLIST WHERE productID = ? and userID = ? ");
        $stmt->execute(array($idProduct, $idUser));
    }
}
