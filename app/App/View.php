<?php
namespace TitipInformatika\Data\App;

class View {

    public static function render(string $view, array $model =[]):void{

        require __DIR__ ."/../View/".$view.".php";
    }
}