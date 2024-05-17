<?php
declare(strict_types=1);

class ShoppingCart{

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

    public function getProductID() : int{
        return $this->productID;
    }

    //querys
    static function getUserShoppingCart(PDO $db, int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM SHOPPINGCART where userID = ?');
            $stmt->execute(array($id));
            $cartItens = array();

            while($cartDB = $stmt->fetch()){
                $cart = new ShoppingCart(intval($cartDB['userID']), intval($cartDB['productID']));
                $cartItens[] = $cart;
            }

            return $cartItens;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function isProductInShoppingCart(PDO $db,int $idUser, int $idProduct){
        try{
            $stmt = $db->prepare('SELECT * FROM SHOPPINGCART where productID = ? and userID = ?');
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

    static function insertProductInShoppingCart(PDO $db, int $idUser, int $idProduct){
        try{
            $stmt=$db->prepare('INSERT INTO SHOPPINGCART VALUES (?,?)');
            $stmt->execute(array($idUser,$idProduct));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function deleteProductInShoppingCart(PDO $db, int $idUser, int $idProduct){
        try{
            $stmt = $db->prepare("DELETE FROM SHOPPINGCART WHERE productID = ? and userID = ? ");
            $stmt->execute(array($idProduct, $idUser));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}