<?php
namespace TitipInformatika\Data\Controller;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\Session;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
use TitipInformatika\Data\Service\SessionService;

class HomeControllerTest extends TestCase{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private HomeController $homeController;

    function setUp():void{
        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->homeController = new HomeController();

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

    }

    public function testGuest(){

        $this->homeController->index();
        $this->expectOutputRegex("[PHP Login Management]");
    }

    public function testUserLogin(){
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));
        $this->userRepository->save($user);

        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id($user->getId());
        $this->sessionRepository->save($session);
        
        $_COOKIE[SessionService::$COOKIE_NAME]= $session->getId();
        $this->homeController->index();
        $this->expectOutputRegex("[Hello Asep Riki]");



    }
    
}