<?php
namespace TitipInformatika\Data\Repository;
use PDO;
use TitipInformatika\Data\Domain\Session;

class SessionRepository {
    private ?PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }

   public function save(Session $session):Session{
    $statement =$this->connection->prepare("INSERT INTO sessions(id,user_id) VALUES(?,?)");
    $statement->execute([$session->getId(),$session->getUser_id()]);

    return $session;
   }

   public function findById(string $id):?Session{
    $statement = $this->connection->prepare("SELECT id, user_id FROM sessions WHERE id=?");
    $statement->execute([$id]);

    try {
        
        if($row = $statement->fetch()){
            $session = new Session();
            $session->setId($row['id']);
            $session->setUser_id($row['user_id']);
            return $session;
        }else{

            return null;
        }

    } finally {
       $statement->closeCursor();
    }
   }

   public function deleteById(string $id):void{
    $statement =$this->connection->prepare("DELETE FROM sessions WHERE id = ?");
    $statement->execute([$id]);
   }

   public function deleteAll():void{
    $statement = $this->connection->prepare("DELETE FROM sessions");
    $statement->execute();
   }
    
}