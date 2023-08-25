<?php
namespace TitipInformatika\Data\Repository;
use PDO;
use TitipInformatika\Data\Domain\User;

class UserRepository{

    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }

    public function save(User $user):User{
       $statement = $this->connection->prepare("INSERT INTO users (id,name,username,password) VALUES(?,?,?,?)");
       $statement->execute([$user->getId(),$user->getName(),$user->getUsername(),$user->getPassword()]);
       return $user;
    }

    public function update(User $user):User{
        $statement = $this->connection->prepare("UPDATE users set name =?,username =?,password=? WHERE id=?");
        $statement->execute([$user->getName(),$user->getUsername(),$user->getPassword(),$user->getId()]);
        return $user;
    }

    public function findById(string $id):?User{
        $statement = $this->connection->prepare("SELECT id,name,username,password FROM users WHERE id =?");
        $statement->execute([$id]);
        try{
            if($row = $statement->fetch()){
                $user = new User();
                $user->setId($row['id']);
                $user->setName($row['name']);
                $user->setUsername($row['username']);
                $user->setPassword($row['password']);
                return $user;
               
            }else{
                return null;
            }
        }finally{
            $statement->closeCursor();
        }
       
    }

    // helper
    public function deleteAll():void{
        $this->connection->exec("DELETE FROM users");
    }

}