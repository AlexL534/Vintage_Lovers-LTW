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
            $product['id'],
            $product['price'],
            $product['quantity'],
            $product['name'],
            $product['description'],
            $product['owner'],
            $product['category'],
            $product['brand'],
        );
    }

    static public function getAllProducts(PDO $db){
        $stmt = $db->prepare(
            'SELECT *
            FROM PRODUCTS'
        );

        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                $productDB['id'],
                $productDB['price'],
                $productDB['quantity'],
                $productDB['name'],
                $productDB['description'],
                $productDB['owner'],
                $productDB['category'],
                $productDB['brand'],
            );

            $products[] = $product;
        }

        return $products;
    }



}