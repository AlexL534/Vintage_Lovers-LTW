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

    static public function getMessages(int $sid, int $rid, int $pid, PDO $db){
        $stmt = $db->prepare('SELECT * FROM MESSAGES WHERE senderID = ? AND receiverID = ? AND productID = ? ORDER BY timestamp');
        $stmt->execute(array($sid,$rid,$pid));
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
    }

    static public function getQuestions(PDO $db,int $sid){
        $stmt = $db->prepare('SELECT DISTINCT receiverID , productID FROM MESSAGES WHERE senderID = ?');
        $stmt->execute(array($sid));
        $questions = $stmt->fetchAll();
        return $questions;
    }

    static public function getQuestionsForSeller(PDO $db, int $rid){
        $stmt = $db->prepare('SELECT DISTINCT senderID , productID FROM MESSAGES WHERE receiverID = ?');
        $stmt->execute(array($rid));
        $questions = $stmt->fetchAll();
        return $questions;
    }

    static public function insertMessage(int $sid, int $rid, int $pid, string $text, PDO $db){
        $stmt = $db->prepare('INSERT INTO MESSAGES(senderID,receiverID,productID,messageText) VALUES (?,?,?,?)');
        $stmt->execute(array($sid,$rid,$pid,$text));
    }

}

?>