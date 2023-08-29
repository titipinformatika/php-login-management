<?php
namespace TitipInformatika\Data\Service;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\Session;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
function setcookie(string $name,string $value,string $time,string $path){
    echo "$name : $value";
}
class SessionServiceTest extends TestCase{


    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;
    private SessionService $sessionService;
    

    function setUp():void{
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository,$this->userRepository);
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId("asep");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));

        $this->userRepository->save($user);
    }

    public function testCreate(){
        $session = $this->sessionService->create("asep");
        $this->expectOutputRegex("[X-TIFOR : {$session->getId()}]");
    }

    public function testDestroy(){
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("asep");
        $this->sessionRepository->save($session);
        $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();

        $this->sessionService->destroy();  
        $this->expectOutputRegex("[X-TIFOR : ]");
        $result = $this->sessionRepository->findById($session->getId());
        self::assertNull($result);

    }

    function testCurrent(){
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("asep");
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();

        $user=$this->sessionService->current();

        self::assertEquals($user->getId(),$session->getUser_id());


    }


}