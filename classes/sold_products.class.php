<?php
declare(strict_types=1);

class SoldProducts{

    private int $buyerID;
    private int $sellerID;
    private int $productID;
    private string $address;

    public function __construct(int $buyerID, int $sellerID, int $productID, string $address){
        $this->buyerID = $buyerID;
        $this->sellerID = $sellerID;
        $this->productID = $productID;
        $this->address = $address;
    }

    public function getBuyerID() : int{
        return $this->buyerID;
    }

    public function getSellerID() : int{
        return $this->sellerID;
    }

    public function getProductID() : int{
        return $this->productID;
    }

    public function getAddressID() : string{
        return $this->address;
    }

    static function getProductsSoldSeller(PDO $db,int $sellerID ){
        $stmt = $db->prepare('SELECT * FROM SOLD_PRODUCTS WHERE sellerID =  ?');
        $stmt->execute(array($sellerID));
        $soldProducts = array();

        while($soldProductDB = $stmt->fetch()){
            $soldProduct = new SoldProducts(intval($soldProductDB['buyerID']), intval($soldProductDB['sellerID']), intval($soldProductDB['productID']), $soldProductDB['address']);
            $soldProducts[] = $soldProduct;
        }

        return $soldProducts;

    }

    static function addProductSold(PDO $db, int $buyerID, int $sellerID, int $productID, string $address){
        $stmt = $db->prepare('INSERT INTO SOLD_PRODUCTS VALUES   (?,?,?,?)');
        $stmt->execute(array($sellerID, $buyerID, $productID, $address));
        
    }



}