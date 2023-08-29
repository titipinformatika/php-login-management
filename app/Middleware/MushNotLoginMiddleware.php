<?php
namespace TitipInformatika\Data\Middleware;
use TitipInformatika\Data\App\View;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
use TitipInformatika\Data\Service\SessionService;

class MushNotLoginMiddleware implements Middleware{
    private SessionService $sessionService;

    public function __construct(){
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());

        $this->sessionService= new SessionService($sessionRepository,$userRepository);
    }

    function bifore():void{
        
        $user = $this->sessionService->current();
        if($user !=null){
            View::redirect("/");
        }

    }
}