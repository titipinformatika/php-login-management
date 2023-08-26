<?php
namespace TitipInformatika\Data\Service;
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Exception\ValidationException;
use TitipInformatika\Data\Model\UserLoginRequest;
use TitipInformatika\Data\Model\UserProfileUpdateRequest;
use TitipInformatika\Data\Model\UserRegisterRequest;
use TitipInformatika\Data\Model\UserUpdatePasswordRequest;
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

    public function testUpdateProfileSuccess(){

        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("rahasiah");
        $this->userRepository->save($user);

        $userProfileUpdateRequest = new UserProfileUpdateRequest();
        $userProfileUpdateRequest->setId("riki");
        $userProfileUpdateRequest->setName("Asep Riki Ganteng");
        $userProfileUpdateRequest->setUsername("asepriki1993");
        $response  =$this->userService->userUpdateProfile($userProfileUpdateRequest);
        self::assertEquals($userProfileUpdateRequest->getName(),$response->user->getName());
        self::assertEquals($userProfileUpdateRequest->getUsername(),$response->user->getUsername());



    }

    public function testUpdateProfileException(){
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("rahasiah");
        $this->userRepository->save($user);
        self::expectException(ValidationException::class);
        $userProfileUpdateRequest = new UserProfileUpdateRequest();
        $userProfileUpdateRequest->setId("");
        $userProfileUpdateRequest->setName("");
        $userProfileUpdateRequest->setUsername("");
        $response  =$this->userService->userUpdateProfile($userProfileUpdateRequest);
        
    }

    public function testUpdateProfileNotFound(){
        $user = new User();
        $user->setId("riki");
        $user->setName("Asep Riki");
        $user->setUsername("asepriki");
        $user->setPassword("rahasiah");
        $this->userRepository->save($user);
        self::expectException(ValidationException::class);
        $userProfileUpdateRequest = new UserProfileUpdateRequest();
        $userProfileUpdateRequest->setId("salah");
        $userProfileUpdateRequest->setName("Asep Riki Ganteng");
        $userProfileUpdateRequest->setUsername("asepriki11234");
        $this->userService->userUpdateProfile($userProfileUpdateRequest);
    }

    public function testUpdatePasswordSuccess(){
        $registerRequest = new UserRegisterRequest();
        $registerRequest->setId("riki");
        $registerRequest->setName("Asep Riki");
        $registerRequest->setUsername("asepriki");
        $registerRequest->setPassword("rahasiah");
        $user = $this->userService->register($registerRequest);
        $request = new UserUpdatePasswordRequest();
        $request->id=$user->user->getId();
        $request->oldPassword ="rahasiah" ;
        $request->password="rahasiahlagi";
        $response = $this->userService->userUpdatePassword($request);

        $this->assertTrue(password_verify($request->password,$response->user->getPassword()));

    }

    public function testUpdatePasswordException(){
        $registerRequest = new UserRegisterRequest();
        $registerRequest->setId("riki");
        $registerRequest->setName("Asep Riki");
        $registerRequest->setUsername("asepriki");
        $registerRequest->setPassword("rahasiah");
        $user = $this->userService->register($registerRequest);
        $this->expectException(ValidationException::class);
        $request = new UserUpdatePasswordRequest();
        $request->id=$user->user->getId();
        $request->oldPassword ="" ;
        $request->password="";
       $this->userService->userUpdatePassword($request);
    }

    public function testUpdatePasswordUserNotFound(){
        $registerRequest = new UserRegisterRequest();
        $registerRequest->setId("riki");
        $registerRequest->setName("Asep Riki");
        $registerRequest->setUsername("asepriki");
        $registerRequest->setPassword("rahasiah");
        $user = $this->userService->register($registerRequest);
        $this->expectException(ValidationException::class);
        $request = new UserUpdatePasswordRequest();
        $request->id="salah";
        $request->oldPassword ="Asep Riki" ;
        $request->password="rahasiah";
       $this->userService->userUpdatePassword($request);
    }
}