 <?php

    // läs in klasser
    require_once('classes/db.static.class.php');
    require_once('classes/twig.class.php');
    require_once('Twig/lib/Twig/Autoloader.php');
    require_once('classes/login.static.class.php');

    session_start();
    // skapa en tom array
    $twig_input = [];
    // och en tom data att skicka in om ingen data finns att skicka
    $data = false;

    // om en klass är satt everythingsthlm.se/klassnamn/
    if(isset($_GET['class'])) {

        // gör om $_GET till $get_array
        $get_array = $_GET;

        // första blir klassnamnet everythingsthlm.se/klassnamn/
        $class = array_shift($get_array);

        // om en metod är satt everythingsthlm.se/klassnamn/metodnamn/
        if(isset($_GET['method'])) {

            // andra blir klassnamnet everythingsthlm.se/klassnamn/metodnamn/
            $method = array_shift($get_array);

        }

        // finns inget metodnamn sätts en generisk
        else {

            $method = 'fallback';

        }

        // finns det några get-variabler kvar så skickas de in som data
        $data = isset($get_array) ? $get_array : false;

    }

    // finns inget klassnamn så sätter vi en generisk
    else {

        $class = 'page';
        $method = 'fallback';

    }

    require_once("classes/".$class.".class.php");
    $class = ucfirst($class);
    $twig_input = $class::$method($data);

    // skapa Twig-objekt med datan vi just hämtat
    $page = new Twig($twig_input);

    // och rita ut sidan
    echo $page->render('index.twig');
