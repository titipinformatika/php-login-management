<?php
use TitipInformatika\Data\App\Routers;
use TitipInformatika\Data\Controller\HomeController;
use TitipInformatika\Data\Middleware\AuthMiddleware;
require_once __DIR__."/../vendor/autoload.php";
Routers::add("GET","/",HomeController::class,'index');
Routers::add("GET","/about",HomeController::class,'about');
Routers::add("GET","/login",HomeController::class,'login');
Routers::add("GET",'/dashboard',HomeController::class,'dashboarad',[AuthMiddleware::class]);
Routers::add("GET",'/product/([a-zA-A0-9]*)/category/([a-zA-Z0-9]*)/([0-9]*)',HomeController::class,'product');
Routers::run();