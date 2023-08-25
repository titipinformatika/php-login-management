<?php

namespace TitipInformatika\Data\Controller;
use TitipInformatika\Data\App\View;
class HomeController {
    public function index(){
      View::render("Home/index",[
        'title'=> "Home"
      ]);
    }

    public function about(){
        echo "HomeController.about()";
    }

    public function product(string $productId,string $categoryId,int $price){
        echo "Product Id : $productId Category : $categoryId price : $price";
    }
    public function dashboard(){
        echo "Dashboard";
    }
    public function login(){
       View::render("Home/login",[
        "title"=> "Login Page"
       ]);
    }
}