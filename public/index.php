<?php
use TitipInformatika\Data\App\Routers;
use TitipInformatika\Data\Config\Database;
use TitipInformatika\Data\Controller\HomeController;
use TitipInformatika\Data\Controller\UserController;
use TitipInformatika\Data\Middleware\MushLoginMiddleware;
use TitipInformatika\Data\Middleware\MushNotLoginMiddleware;


require_once __DIR__."/../vendor/autoload.php";
Database::getConnection("prod");
// Home Controller
Routers::add("GET","/",HomeController::class,'index',[]);

// User Controller

Routers::add("GET","/user/register",UserController::class,'register',[MushNotLoginMiddleware::class]);
Routers::add("POST","/user/register",UserController::class,"postRegister",[MushNotLoginMiddleware::class]);
Routers::add("GET","/user/login",UserController::class,"login",[MushNotLoginMiddleware::class]);
Routers::add("POST","/user/login",UserController::class,"postLogin",[MushNotLoginMiddleware::class]);

Routers::add("GET","/user/logout",UserController::class,"logout",[MushLoginMiddleware::class]);
Routers::add("GET","/user/profile",UserController::class,"updateProfile",[MushLoginMiddleware::class]);
Routers::add("POST","/user/profile",UserController::class,"postUpdateProfile",[MushLoginMiddleware::class]);
Routers::add("GET","/user/password",UserController::class,'updatePassword',[MushLoginMiddleware::class]);
Routers::add("POST","user/password",UserController::class,"postUpdatePassword",[MushLoginMiddleware::class]);




Routers::run();