<?php
namespace TitipInformatika\Data\Repository;
use PDO;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\Session;
use TitipInformatika\Data\Domain\User;
class SessionRepositoryTest extends TestCase{

    private PDO $connection;
    private SessionRepository $repository;
    private UserRepository $userRepository;

    function setUp():void{
        $this->connection = Database::getConnection();
        $this->repository = new SessionRepository($this->connection);
        $this->userRepository = new UserRepository($this->connection);
        $this->repository->deleteAll(); 
        $this->userRepository->deleteAll();
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));

        $this->userRepository->save($user);
    }

    function testSaveSession(){
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("riki");

        $result=$this->repository->save($session);
        self::assertEquals($session->getId(),$result->getId());
        self::assertEquals($session->getUser_id(),$result->getUser_id());
        

    }

    function testDeleteSessionById(){
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("riki");
        $result = $this->repository->save($session);
        $this->repository->deleteById($result->getId());
        self::assertNull($this->repository->findById($result->getId()));
    }

    public function testFindById(){
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("riki");
        $this->repository->save($session);

        $result = $this->repository->findById($session->getId());
        self::assertEquals($session->getId(),$result->getId());
        self::assertEquals($session->getUser_id(),$result->getUser_id());
        self::assertNotNull($result);
    }

}