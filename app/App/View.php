<?php
namespace TitipInformatika\Data\App;

class View {

    public static function render(string $view, array $model =[]):void{

        require __DIR__ ."/../View/header.php";
        require __DIR__ ."/../View/".$view.".php";
        require __DIR__ ."/../View/footer.php";
    }

    public static function redirect(string $url):void{
        header("Location: $url");
        if (getenv("mode") != "test") {
            exit();
        }
    }
}