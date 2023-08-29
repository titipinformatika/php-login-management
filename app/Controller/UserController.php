<?php
namespace TitipInformatika\Data\Controller;
use TitipInformatika\Data\App\View;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Model\UserRegisterRequest;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
use TitipInformatika\Data\Service\SessionService;
use TitipInformatika\Data\Service\UserService;

class UserController {
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct(){
        $userRepository=new UserRepository(Database::getConnection());
        $this->userService = new UserService($userRepository);
        $sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository,$userRepository);
    }
    
    public function register(){
        
        View::render("User/register",[
            'title'=>"Register new user"
        ]);
    }

    public function postRegister(){
        $request = new UserRegisterRequest();
        $request->setId($_POST['id']);
        $request->setName($_POST['name']);
        $request->setUsername($_POST['username']);
        $request->setPassword($_POST['password']);
        $this->userService->register($request);
        View::redirect("/user/login");

    }

    public function login(){}


    public function postLogin(){

    }

    public function logout(){}

    public function updateProfile(){}

    public function postUpdateProfile(){}

    public function updatePassword(){}

    public function postUpdatePassword(){}

         
    
}