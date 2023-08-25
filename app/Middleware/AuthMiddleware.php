<?php
namespace TitipInformatika\Data\Middleware;

class AuthMiddleware implements Middleware{

    public function bifore():void{

        session_start();
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            exit;
        }
    }
}