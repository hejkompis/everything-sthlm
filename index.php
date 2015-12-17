 <?php

    // läs in klasser
    include_once('classes/db.class.php');
    include_once('classes/twig.class.php');
    include_once('Twig/lib/Twig/Autoloader.php');

    $data = array('title' => 'Everything STHLM', 'page' => 'home.twig');

	// skapa Twig-objekt med datan vi just hämtat
	$page = new Twig(['data' => $data]);
	
	// och rita ut sidan
	echo $page->render('index.twig');