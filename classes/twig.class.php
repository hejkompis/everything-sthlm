<?php 

class Twig {

    private $data, $twig;

    function __construct( $data = [], $templateSource = 'templates/') {

        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem($templateSource);
        $this->twig = new Twig_Environment($loader);

        $this->data = $data;

    }

    function addData($data = false) {
        $this->data = $data;
    }
    
    function render($target){

        return $this->twig->render($target, $this->data);

    }

}
