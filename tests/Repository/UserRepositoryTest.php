<?php
namespace TitipInformatika\Data\Repository;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\User;

class UserRepositoryTest extends TestCase{

    private UserRepository $userRepository;

    function setUp():void{
        $this->userRepository = new UserRepository(Database::getconnection());

        $this->userRepository->deleteAll();
    }

    public function testSave(){

        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("asepriki");

        $result = $this->userRepository->save($user);
        self::assertEquals($result->getId(),$user->getId());
        self::assertEquals($result->getName(),$user->getName());
        self::assertEquals($result->getUsername(),$user->getUsername());
        self::assertEquals($result->getPassword(),$user->getPassword());

    }

    public function testFindById(){
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("asepriki");
        $this->userRepository->save($user);
        $result = $this->userRepository->findById("riki");
        self::assertEquals($result->getId(),$user->getId());
        self::assertEquals($result->getName(),$user->getName());
        self::assertEquals($result->getUsername(),$user->getUsername());
        self::assertEquals($result->getPassword(),$user->getPassword());
    }

    public function testFindByIdNotFound(){
        $result = $this->userRepository->findById("notFound");
        self::assertNull($result);
    }

    public function testUpdate(){
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("asepriki");

        $this->userRepository->save($user);


        $user->setName("Asep Riki Ganteng");

        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->getId());
        self::assertEquals($result->getId(),$user->getId());
        self::assertEquals($result->getName(),$user->getName());
        self::assertEquals($result->getUsername(),$user->getUsername());
        self::assertEquals($result->getPassword(),$user->getPassword());

    }
}