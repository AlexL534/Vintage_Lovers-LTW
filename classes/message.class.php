<?php

declare(strict_types = 1);

class UserMessage{
    private int $senderID;
    private int $receiverID;
    private int $productID;
    private string $text;
    private int $timestamp;

    public function __construct(int $sid, int $rID, int $pID, string $text, int $timestamp){
        $this->senderID = $sid;
        $this->receiverID = $rID;
        $this->productID = $pID;
        $this->text = $text;
        $this->timestamp = $timestamp;
    }

    //getters
    public function getSenderID() : int{
        return $this->senderID;
    }

    public function getReceiverID() : int{
        return $this->receiverID;
    }

    public function getProductID() : int{
        return $this->productID;
    }

    public function getText() : string{
        return $this->text;
    }

    public function getTime() : int{
        return $this->timestamp;
    }

    //querys
    static public function getMessages(int $id,int $id2, int $pid, PDO $db){
        try{
        $stmt = $db->prepare('SELECT * FROM MESSAGES WHERE (senderID = ? OR receiverID = ?) AND (senderID = ? OR receiverID = ?) AND productID = ? ORDER BY timestamp');
        $stmt->execute(array($id,$id,$id2,$id2,$pid));
        $messages = array();
        while($mesDB = $stmt->fetch()){
            $mes = new UserMessage(
                intval($mesDB['senderID']),
                intval($mesDB['receiverID']),
                intval($mesDB['productID']),
                $mesDB['messageText'],
                intval($mesDB['timestamp'])

            );
            $messages[] = $mes;
        }

        return $messages;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    static public function getQuestions(PDO $db,int $sid){
        try{
            $stmt = $db->prepare('SELECT DISTINCT receiverID , productID FROM MESSAGES WHERE senderID = ?');
            $stmt->execute(array($sid));
            $questions = $stmt->fetchAll();
            $stmt = $db->prepare('SELECT DISTINCT senderID , productID FROM MESSAGES WHERE receiverID = ?');
            $stmt->execute(array($sid));
            while($qDB=$stmt->fetch()){
                $questions [] = $qDB;
            }
            return $questions;
            } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    static public function insertMessage(int $sid, int $rid, int $pid, string $text, PDO $db){
        try{
            $stmt = $db->prepare('INSERT INTO MESSAGES(senderID,receiverID,productID,messageText) VALUES (?,?,?,?)');
            $stmt->execute(array($sid,$rid,$pid,$text));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}

?>