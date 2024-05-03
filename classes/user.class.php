<?php

declare(strict_types = 1);
class User{

    private int $id;

    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private int $isadmin;

    public function __construct(int $id,string $name, string $username, string $email, string $password, int $isadmin){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isadmin = $isadmin;
        $this->name = $name;
    }

    public function getID() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getUsername() : string{
        return $this->username;
    }

    public function getEmail() : string{
        return $this->email;
    }

    public function getPassword() : string{
        return $this->password;    
    }

    public function getIsAdmin() : int{
        return $this->isadmin;
    }

    public function getUserOwnedItems(PDO $db){
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
                isset($productDB['quantity']) ? $productDB['quantity'] : 1,
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

    public function deleteUser(PDO $db): bool {
        try {
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function getUser(PDO $db, int $id){
        $stmt = $db->prepare('
            SELECT id, name,  username, email, password, is_admin
            FROM USERS
            WHERE id = ?
            ');
        
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return new User(
            $user['id'],
            $user['name'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['is_admin']
        );

    }

    static function getAllUsers(PDO $db): array {
        $stmt = $db->prepare('
            SELECT id, name, username, email, password, is_admin
            FROM USERS
        ');
        
        $stmt->execute();
        
        $users = [];
        while ($user = $stmt->fetch()) {
            $users[] = new User(
                $user['id'],
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['is_admin']
            );
        }
    
        return $users;
    }
    

    static function getUserByPassword(PDO $db, string $email, string $password){
        $stmt = $db->prepare(
            'SELECT id, name,  username, email, password, is_admin
            FROM USERS
            WHERE email = ? AND password = ?'
        );
        
        $stmt->execute(array($email, $password));
        if($user = $stmt->fetch()){

            return new User(
                $user['id'],
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['is_admin'],
            );
        } else return null;
    }

    static function getUserByEmail(PDO $db, string $email){
        $stmt = $db->prepare(
            'SELECT id, name,  username, email, password, is_admin
            FROM USERS
            WHERE email = ?'
        );
        
        $stmt->execute(array($email));
        if($user = $stmt->fetch()){

            return new User(
                $user['id'],
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['is_admin'],
            );
        } else return null;
    }

    static function emailExists(PDO $db, string $email) : bool{
        $stmt = $db->prepare(
            'SELECT email
            FROM USERS
            WHERE email = ?'
        );

        $stmt->execute(array($email));

        if($stmt->fetch()){
            //the email already exists
            return true;
        }
        else{
            //the email doesn´t exists
            return false;
        }
    }

    static function usernameExists(PDO $db, string $username) : bool{
        $stmt = $db->prepare(
            'SELECT username
            FROM USERS
            WHERE username = ?'
        );

        $stmt->execute(array($username));

        if($stmt->fetch()){
            //the username already exists
            return true;
        }
        else{
            //the username doesn´t exists
            return false;
        }
    }

    static function insertNewUser(PDO $db, string $name, string $username, string $email, string $password){
        $stmt = $db->prepare(
            'INSERT INTO USERS(username, name, email, password, is_admin) 
            VALUES (?, ?, ?, ?, 0)'
        );

        $stmt->execute(array($username, $name, $email, $password));
    }

    static function searchUsers(PDO $db, string $searchQuery) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE :search_query");
            $stmt->bindValue(':search_query', '%' . $searchQuery . '%', PDO::PARAM_STR);
            $stmt->execute();
            
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $searchResults;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    static public function updateAdminStatus(PDO $db, int $userId): bool
    {
        try {
            $stmt = $db->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
            $result = $stmt->execute([$userId]);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}