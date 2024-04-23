<?php

declare(strict_types = 1);

class Product{

    private int $id;
    private int $price;
    private int $quantity;
    private string $name;
    private string $description;
    private int $owner;
    private int $category;
    private int $brand;

    public function __construct(int $id, int $price, int $quantity, string $name, string $description, int $owner, int $category, int $brand){
        $this->id = $id;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->name = $name;
        $this->description = $description;
        $this->owner = $owner;
        $this->category = $category;
        $this->brand = $brand;
    }

    public function getId() : int{
        return $this->id;
    }

    public function getPrice() : int{
        return $this->price;
    }

    public function getQuantity() : int{
        return $this->quantity;
    }

    public function getName() : string{
        return $this->name;
    }

    public function getDescription() : string{
        return $this->description;
    }

    public function getOwner() : int{
        return $this->owner;
    }

    public function getCategory() : int{
        return $this->category;
    }

    public function getbrand() : int{
        return $this->brand;
    }

    static public function getProduct(PDO $db, int $id){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE id = ?'
        );

        $stmt->execute(array($id));
        $product = $stmt->fetch();

        return new Product(
            intval($product['id']),
            intval($product['price']),
            intval($product['quantity']),
            $product['name'],
            $product['description'],
            intval($product['owner']),
            intval($product['category']),
            intval($product['brand']),
        );
    }

    static public function getProductByPrice(PDO $db, int $lowerPrice, int $upperPrice){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE price >= ? AND price <= ?'
        );
        $stmt->execute(array($lowerPrice, $upperPrice));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                intval($productDB['price']),
                intval($productDB['quantity']),
                $productDB['name'],
                $productDB['description'],
                intval($productDB['owner']),
                intval($productDB['category']),
                intval($productDB['brand'])
            );
            $products[] = $product;
        }
        return $products;
    }
    static public function getProductByName(PDO $db, string $name){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE name LIKE ?'
        );
        $stmt->execute(array('%' . $name . '%'));
        
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                intval($productDB['price']),
                intval($productDB['quantity']),
                $productDB['name'],
                $productDB['description'],
                intval($productDB['owner']),
                intval($productDB['category']),
                intval($productDB['brand'])
            );
            $products[] = $product;
        }
        return $products;
    }

    static public function getAllProducts(PDO $db){
        $stmt = $db->prepare(
            'SELECT *
            FROM PRODUCTS'
        );
        $stmt->execute();
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                intval($productDB['price']),
                intval($productDB['quantity']),
                $productDB['name'],
                $productDB['description'],
                intval($productDB['owner']),
                intval($productDB['category']),
                intval($productDB['brand'])
            );
            
            $products[] = $product;
        }

        return $products;
    }
}