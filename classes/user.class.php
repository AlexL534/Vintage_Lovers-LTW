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

    //getters
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

    //querys
    public function getUserOwnedItems(PDO $db){
        try{
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
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
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
        try{
            $stmt = $db->prepare('
                SELECT id, name,  username, email, password, is_admin
                FROM USERS
                WHERE id = ?
                ');
            
            $stmt->execute(array($id));
            $user = $stmt->fetch();

            return new User(
                intval($user['id']),
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
                intval($user['is_admin'])
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    static function getAllUsers(PDO $db): array {
        try{
            $stmt = $db->prepare('
                SELECT id, name, username, email, password, is_admin
                FROM USERS
            ');
            
            $stmt->execute();
            
            $users = [];
            while ($user = $stmt->fetch()) {
                $users[] = new User(
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    intval($user['is_admin'])
                );
            }
        
            return $users;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    

    static function getUserByPassword(PDO $db, string $email, string $password){
        try{
            $stmt = $db->prepare(
                'SELECT id, name,  username, email, password, is_admin
                FROM USERS
                WHERE email = ? AND password = ?'
            );
            
            $stmt->execute(array($email, $password));
            if($user = $stmt->fetch()){

                return new User(
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    intval($user['is_admin']),
                );
            } else return null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function getUserByEmail(PDO $db, string $email){
        try{
            $stmt = $db->prepare(
                'SELECT id, name,  username, email, password, is_admin
                FROM USERS
                WHERE email = ?'
            );
            
            $stmt->execute(array($email));
            if($user = $stmt->fetch()){

                return new User(
                    intval($user['id']),
                    $user['name'],
                    $user['username'],
                    $user['email'],
                    $user['password'],
                    intval($user['is_admin']),
                );
            } else return null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function emailExists(PDO $db, string $email) : bool{
        try{
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
                //the email doesn't exist
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function usernameExists(PDO $db, string $username) : bool{
        try{
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
                //the username doesn't exist
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function insertNewUser(PDO $db, string $name, string $username, string $email, string $password){
        try{
            $stmt = $db->prepare(
                'INSERT INTO USERS(username, name, email, password, is_admin) 
                VALUES (?, ?, ?, ?, 0)'
            );

            $stmt->execute(array($username, $name, $email, $password));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static function searchUsers(PDO $db, string $searchQuery, string $userType = 'all') {
        try {
            if (!in_array($userType, ['all', 'admin', 'normal'])) {
                throw new InvalidArgumentException("Invalid user type");
            }
    
            $query = "SELECT * FROM users WHERE username LIKE :search_query";
            
            if ($userType !== 'all') {
                $query .= " AND is_admin = :is_admin";
            }
    
            $stmt = $db->prepare($query);
            $stmt->bindValue(':search_query', '%' . $searchQuery . '%', PDO::PARAM_STR);
            
            if ($userType !== 'all') {
                $isAdmin = ($userType === 'admin') ? 1 : 0;
                $stmt->bindValue(':is_admin', $isAdmin, PDO::PARAM_INT);
            }   
    
            $stmt->execute();
            
            $searchResults = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $searchResults[] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'isAdmin' => intval($row['is_admin'])
                ];
            }
            return $searchResults;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (InvalidArgumentException $e) {
            error_log("Invalid Argument: " . $e->getMessage());
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

    static public function updateUsername(PDO $db, int $id, string $username ) : bool{
        try{
            $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
            $result = $stmt->execute(array($username, $id));
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function updateName(PDO $db, int $id, string $name ) : bool{
        try{
            $stmt = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
            $result = $stmt->execute(array($name, $id));
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function updatePassword(PDO $db, int $id, string $password) : bool{
        try{
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result = $stmt->execute(array($password, $id));
        return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
}