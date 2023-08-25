<?php
namespace TitipInformatika\Data\Service;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Exception\ValidationException;
use TitipInformatika\Data\Model\UserLoginRequest;
use TitipInformatika\Data\Model\UserRegisterRequest;
use TitipInformatika\Data\Repository\UserRepository;

class UserServiceTest extends TestCase{

    private UserRepository $userRepository;
    private UserService $userService;

    function setUp():void{
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userService = new UserService($this->userRepository);
        $this->userRepository->deleteAll();
    }

    public function testRegistrationSuccess(){
        $request = new UserRegisterRequest();
        $request->setId("asep");
        $request->setName("Asep Riki");
        $request->setUsername("asepriki");
        $request->setPassword("rahasiah");

        $resposen = $this->userService->register($request);

        $this->assertEquals($request->getId(),$resposen->user->getId());
        $this->assertEquals($request->getName(),$resposen->user->getName());
        $this->assertEquals($request->getUsername(),$resposen->user->getUsername());
        $this->assertNotEquals($request->getPassword(),$resposen->user->getPassword());
        $this->assertTrue(password_verify($request->getPassword(),$resposen->user->getPassword()));

    }

    public function testRegistrationException(){
        $this->expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->setId("");
        $request->setName("");
        $request->setUsername("asepriki");
        $request->setPassword("rahasiah");

        $resposen = $this->userService->register($request);
    }

    public function testRegistrationDuplikate(){
        $user = new User();
        $user->setId("asep");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));
        $this->userRepository->save($user);


        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->setId("asep");
        $request->setName("Asep Riki");
        $request->setUsername("asepriki");
        $request->setPassword("rahasiah");
        $this->userService->register($request);
    }

    public function testLoginException(){
        $user = new User();
        $user->setId("asep");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));
        $this->userRepository->save($user);
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->setId("asep");
        $request->setUsername("");
        $request->setPassword("");
        $this->userService->login($request);
    }

    function testLoginWorngException(){
        $user = new User();
        $user->setId("asep");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));
        $this->userRepository->save($user);
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();

        $request->setId("asep");
        $request->setUsername("asepriki");
        $request->setPassword("salah");
        $this->userService->login($request);
    }

    function testLoginSuccess(){
        
            $user = new User();
            $user->setId("asep");
            $user->setName("Asep Riki");
            $user->setUsername("asepriki");
            $user->setPassword(password_hash("rahasiah",PASSWORD_BCRYPT));
            $this->userRepository->save($user);
            $request = new UserLoginRequest();
    
            $request->setId("asep");
            $request->setUsername("asepriki");
            $request->setPassword("rahasiah");
            $response= $this->userService->login($request);

            self::assertEquals($user->getId(),$response->user->getId());
            self::assertEquals($user->getName(),$response->user->getName());
            self::assertEquals($user->getUsername(),$response->user->getUsername());
            self::assertEquals($user->getPassword(),$response->user->getPassword());
            self::assertTrue(password_verify($request->getPassword(),$response->user->getPassword()));


        
    }
}