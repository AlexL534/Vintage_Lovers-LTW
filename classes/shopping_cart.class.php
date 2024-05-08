<?php
declare(strict_types=1);

class ShoppingCart{

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

    static function getUserShoppingCart(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM SHOPPINGCART where userID = ?');
        $stmt->execute(array($id));
        $cartItens = array();

        while($cartDB = $stmt->fetch()){
            $cart = new ShoppingCart(intval($cartDB['userID']), intval($cartDB['productID']));
            $cartItens[] = $cart;
        }

        return $cartItens;
    }

    static function isProductInShoppingCart(PDO $db,int $idUser, int $idProduct){
        $stmt = $db->prepare('SELECT * FROM SHOPPINGCART where productID = ? and userID = ?');
        $stmt->execute(array($idProduct, $idUser));
        $product = $stmt->fetchAll();

        if(empty($product)){
            return false;
        }

        return true;
    }

    static function insertProductInShoppingCart(PDO $db, int $idUser, int $idProduct){
        $stmt=$db->prepare('INSERT INTO SHOPPINGCART VALUES (?,?)');
        $stmt->execute(array($idUser,$idProduct));
    }
}