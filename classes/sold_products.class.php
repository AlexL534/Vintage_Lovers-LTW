<?php
declare(strict_types=1);

class SoldProducts{

    private int $sellID;
    private int $buyerID;
    private int $sellerID;
    private int $productID;
    private string $address;

    public function __construct(int $sellID,int $buyerID, int $sellerID, int $productID, string $address){
        $this->sellID = $sellID;
        $this->buyerID = $buyerID;
        $this->sellerID = $sellerID;
        $this->productID = $productID;
        $this->address = $address;
    }

    //getters
    public function getBuyerID() : int{
        return $this->buyerID;
    }

    public function getSellerID() : int{
        return $this->sellerID;
    }

    public function getSellID() : int{
        return $this->sellID;
    }


    public function getProductID() : int{
        return $this->productID;
    }

    public function getAddress() : string{
        return $this->address;
    }

    //querys
    static function getProductSold(PDO $db,int $id){
        try{
            $stmt = $db->prepare('SELECT * FROM SOLD_PRODUCTS WHERE sellID =  ?');
            $stmt->execute(array($id));
            $soldProductDB = $stmt->fetch();
            $soldProduct = new SoldProducts(intval($soldProductDB['sellID']),intval($soldProductDB['buyerID']), intval($soldProductDB['sellerID']), intval($soldProductDB['productID']), $soldProductDB['address']);
            return $soldProduct;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function getProductsSoldSeller(PDO $db,int $sellerID ){
        try{
            $stmt = $db->prepare('SELECT * FROM SOLD_PRODUCTS WHERE sellerID =  ?');
            $stmt->execute(array($sellerID));
            $soldProducts = array();

            while($soldProductDB = $stmt->fetch()){
                $soldProduct = new SoldProducts(intval($soldProductDB['sellID']),intval($soldProductDB['buyerID']), intval($soldProductDB['sellerID']), intval($soldProductDB['productID']), $soldProductDB['address']);
                $soldProducts[] = $soldProduct;
            }

            return $soldProducts;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    static function addProductSold(PDO $db, int $buyerID, int $sellerID, int $productID, string $address){
        try{
            $stmt = $db->prepare('INSERT INTO SOLD_PRODUCTS(sellerID, buyerID, productID, address) VALUES  (?,?,?,?)');
            $stmt->execute(array($sellerID, $buyerID, $productID, $address));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }    
    }

    static function deleteProductSoldProduct(PDO $db, int $productID){
        try{
            $stmt = $db->prepare('DELETE FROM SOLD_PRODUCTS where productID = ?');
            $stmt->execute(array($productID));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function deleteProductSoldUser(PDO $db, int $userID){
        try{
            $stmt = $db->prepare('DELETE FROM SOLD_PRODUCTS where sellerID = ? or buyerID = ?');
            $stmt->execute(array($userID, $userID));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



}