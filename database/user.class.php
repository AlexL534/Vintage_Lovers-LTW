<?php

declare(strict_types = 1);
class User{

    private int $id;
    private string $username;
    private string $email;
    private int $isadmin;

    public function __construct(int $id, string $username, string $email, int $isadmin){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->isadmin = $isadmin;
    }

    public function getUsername() : string{
        return $this->username;
    }

    public function getEmail() : string{
        return $this->email;
    }

    public function getIsAdmin() : int{
        return $this->isadmin;
    }

   public function getUserOwnedItens(PDO $db){
        $stmt = $db->prepare('
            SELECT *
            FROM PRODUCTS
            WHERE owner = ?
            ');
        
        $stmt->execute(array($this->id));
        
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

    static function getUser(PDO $db, int $id){
        $stmt = $db->prepare('
            SELECT id, username, email, is_admin
            FROM USERS
            WHERE id = ?
            ');
        
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return new User(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['isadmin']
        );

    }





}