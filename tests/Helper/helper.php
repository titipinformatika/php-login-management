<?php

namespace TitipInformatika\Data\App {

    function header(string $value){
        echo $value;
    }

}

namespace TitipInformatika\Data\Service {

    function setcookie(string $name, string $value){
        echo "$name: $value";
    }

}