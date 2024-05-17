<?php

declare(strict_types = 1);
class Wishlist{

    private int $userID;
    private int $productID;

    public function __construct(int $userID, int $productID){
        $this->userID= $userID;
        $this->productID= $productID;

    }

    //getters
    public function getUserID() : int{
        return $this->userID;
    }

    //setters
    public function getProductID() : int{
        return $this->productID;
    }

    //querys
    static function getUserWishlist(PDO $db, int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM WISHLIST where userID = ?');
            $stmt->execute(array($id));
            $listItens = array();

            while($listDB = $stmt->fetch()){
                $list = new Wishlist(intval($listDB['userID']), intval($listDB['productID']));
                $listItens[] = $list;
            }

            return $listItens;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function isProductInWishlist(PDO $db,int $idUser, int $idProduct){
        try{
            $stmt = $db->prepare('SELECT * FROM WISHLIST where productID = ? and userID = ?');
            $stmt->execute(array($idProduct, $idUser));
            $product = $stmt->fetchAll();

            if(empty($product)){
                return false;
            }

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function insertProductInWishlist(PDO $db, int $idUser, int $idProduct){
        try{
            $stmt=$db->prepare('INSERT INTO WISHLIST VALUES (?,?)');
            $stmt->execute(array($idUser,$idProduct));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function deleteProductInWishlist(PDO $db, int $idUser, int $idProduct){
        try{
        $stmt = $db->prepare("DELETE FROM WISHLIST WHERE productID = ? and userID = ? ");
        $stmt->execute(array($idProduct, $idUser));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
