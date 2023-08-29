<?php
namespace TitipInformatika\Data\Service;
use TitipInformatika\Data\Domain\Session;
use TitipInformatika\Data\Domain\User;
use TitipInformatika\Data\Repository\SessionRepository;
use TitipInformatika\Data\Repository\UserRepository;
class SessionService {

    public static string $COOKIE_NAME = "X-TIFOR";

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository,UserRepository $userRepository){
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $user_id):Session{
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id($user_id);
        $this->sessionRepository->save($session);
        setcookie(self::$COOKIE_NAME,$session->getId(),time()+(60*60*24*30),"/");
        return $session;

    }

    public function destroy():void{
        $session_id = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($session_id);
        setcookie(self::$COOKIE_NAME,'',1,'/');
    }

    public function current():?User{
        $session_id = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $session = $this->sessionRepository->findById($session_id);
        if($session == null){
            return null;
        }

        return $this->userRepository->findById($session->getUser_id());

    }



}