<?php
declare(strict_types=1);


class Condition{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(int $id, string $name, string $description){
        $this->id= $id;
        $this->name= $name;
        $this->description=$description;

    }


    //getters
    public function getId() : int{
        return $this->id;
    }

    public function getName() : string{
        return $this->name;
    }

    public function getDescription() : string{
        return $this->description;
    }

    //queries
    static public function getConditionById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM CONDITION WHERE conditionID = ?');
        $stmt->execute(array($id));
        $conditionDB = $stmt->fetch(); 

        return new Condition(
            intval($conditionDB['conditionID']),
            $conditionDB['name'],
            $conditionDB['description']
        );
    }

    static public function getConditionByName(PDO $db, string $name){
        $stmt = $db->prepare('SELECT * FROM CONDITION WHERE name = ?');
        $stmt->execute(array($name));
        $conditionDB = $stmt->fetch();
        
        return new Condition(
            intval($conditionDB['conditionID']),
            $conditionDB['name'],
            $conditionDB['description']
        );
    }

    static public function getAllCondition(PDO $db){
        $stmt = $db->prepare('SELECT * FROM CONDITION');
        $stmt->execute();
        $conditions = array();
        while($conditionDB = $stmt->fetch()){
            $condition= new Condition(intval($conditionDB['conditionID']),$conditionDB['name'],$conditionDB['description']);

            $conditions[]=$condition;
        }

        return $conditions;
    }

    static function getConditionsOfProduct(PDO $db , int $id){
        $stmt = $db->prepare('SELECT conditionID FROM CONDITION_OF_PRODUCT WHERE productID = ?');
        $stmt->execute(array($id));
        $conditions = array();
        while($conditionID=$stmt->fetch()){
            $condition = Condition::getConditionById($db,intval($conditionID['conditionID']));
            $conditions[] = $condition;
        }
        return $conditions;
    }
}
?>