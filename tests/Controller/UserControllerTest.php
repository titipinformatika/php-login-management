<?php
namespace TitipInformatika\Data\Controller;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
use TitipInformatika\Data\Service\UserService;
require_once __DIR__ . '/../Helper/helper.php';
class UserControllerTest extends TestCase{

    private UserController $userController;
    private UserService $userService;
    function setUp():void{
        $this->userController = new UserController();
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->userService= new UserService($userRepository);
        $sessionRepository->deleteAll();
        $userRepository->deleteAll();
        putenv("mode=test");

    }

    public function testRegister(){
        $this->userController->register();
        $this->expectOutputRegex("[Titip Informatika]");
        $this->expectOutputRegex("[Register new user]");
    }

    
    public function testPostRegister(){
        

        $_POST['id']="riki";
        $_POST['name']="Asep Riki";
        $_POST["username"]="asepriki";
        $_POST['password']="rahasiah";
        $this->userController->postRegister();
        $this->expectOutputRegex("[Location: /user/login]");
    }
}