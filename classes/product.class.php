<?php

declare(strict_types = 1);

class Product{

    private int $id;
    private float $price;
    private int $quantity;
    private string $name;
    private string $description;
    private int $owner;
    private int $category;
    private int $brand;

    public function __construct(int $id, float $price, int $quantity, string $name, string $description, int $owner, int $category, int $brand){
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

    public function getPrice() : float{
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

    public function getBrand() : int{
        return $this->brand;
    }

    public function save(PDO $db): bool
    {
        try {
            $stmt = $db->prepare("INSERT INTO PRODUCTS (name, description, price, owner, brand, category) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$this->name, $this->description, $this->price, $this->owner, $this->brand, $this->category]);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getProduct(PDO $db, int $id){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE id = ?'
        );

        $stmt->execute(array($id));
        $product = $stmt->fetch();

        if(empty($product)){
            return null;
        }

        return new Product(
            intval($product['id']),
            floatval($product['price']),
            intval($product['quantity']),
            $product['name'],
            $product['description'],
            intval($product['owner']),
            intval($product['category']),
            intval($product['brand']),
        );
    }

    static public function getProductByPrice(PDO $db, float $lowerPrice, float $upperPrice){
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
                floatval($productDB['price']),
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

    static public function getProductByCategory(PDO $db, int $categoryID){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE category = ?'
        );
        $stmt->execute(array($categoryID));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
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

    static public function getProductByColor(PDO $db, int $colorID){
        $stmt = $db->prepare(
            'SELECT p.id, p.price, p.quantity, p.name, p.description, p.owner, p.category, p.brand
            FROM PRODUCTS p join colors_of_product c on c.productID = p.id
            WHERE c.colorid = ?'
        );
        $stmt->execute(array($colorID));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
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

    static public function getProductByBrand(PDO $db, int $brandID){
        $stmt = $db->prepare(
            'SELECT id, price, quantity, name, description, owner, category, brand
            FROM PRODUCTS
            WHERE brand= ?'
        );
        $stmt->execute(array($brandID));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
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

    static public function getProductByCondition(PDO $db, int $conditionID){
        $stmt = $db->prepare(
            'SELECT p.id, p.price, p.quantity, p.name, p.description, p.owner, p.category, p.brand
            FROM PRODUCTS p join condition_of_product c on c.productID = p.id
            WHERE c.conditionid = ?'
        );
        $stmt->execute(array($conditionID));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
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

    static public function getProductBySize(PDO $db, int $sizeID){
        $stmt = $db->prepare(
            'SELECT p.id, p.price, p.quantity, p.name, p.description, p.owner, p.category, p.brand
            FROM PRODUCTS p join size_of_product s on s.productID = p.id
            WHERE s.sizeID = ?'
        );
        $stmt->execute(array($sizeID));
        $products = array();
        while($productDB = $stmt->fetch()){
            $product = new Product(
                intval($productDB['id']),
                floatval($productDB['price']),
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
                floatval($productDB['price']),
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
                floatval($productDB['price']),
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

    static public function searchProducts(PDO $db, $searchQuery) {
        try {
            $stmt = $db->prepare("SELECT * FROM PRODUCTS WHERE NAME LIKE :search_query");
            $stmt->bindValue(':search_query', '%' . $searchQuery . '%', PDO::PARAM_STR);
            $stmt->execute();
            
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $searchResults;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }    

    static public function deleteProduct(PDO $db, int $productId): bool
    {
        try {
            $stmt = $db->prepare("DELETE FROM PRODUCTS WHERE id = ?");
            $result = $stmt->execute([$productId]);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function updateProduct(PDO $db, int $productId, string $name, string $description, float $price): bool
    {
        try {
            $stmt = $db->prepare("UPDATE PRODUCTS SET name = ?, description = ?, price = ? WHERE id = ?");
            $result = $stmt->execute([$name, $description, $price, $productId]);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}