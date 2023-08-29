<?php

namespace TitipInformatika\Data\Controller;
use TitipInformatika\Data\App\View;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
use TitipInformatika\Data\Service\SessionService;
class HomeController {
   private SessionService $sessionService;

   public function __construct(){
      $connection = Database::getConnection();
      $sessionRepository = new SessionRepository($connection);
      $userRepository = new UserRepository($connection);
      $this->sessionService = new SessionService($sessionRepository,$userRepository);
   }

   public function index(){
    $user = $this->sessionService->current();

    if($user == null){
      View::render('Home/index',[
        'title'=>"PHP Login Management"
      ]);
    }else{
      View::render('Home/dashboard',[
        'title'=> "Dashboard",
        'user'=>[
          "name"=> $user->getName()
        ]
      ]);
    }
   }
}