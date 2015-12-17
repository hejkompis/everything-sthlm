<?php

	define('ROOT', '../');

	// läs in klasser
	include('../classes/db.class.php');
	include('../classes/user.class.php');
	include('../classes/dashboard.class.php');
	include('../classes/category.class.php');
	include('../classes/twig.class.php');

	session_start();

	$user = isset($_SESSION['phlogger_user']) ? $_SESSION['phlogger_user'] : false;

	// om man ska logga in, kolla om det finns en user och formuläret skickats
	if(!$user && isset($_POST['check_login_form'])) {

		// kör funktion för att logga in
		$user = new User();
		$user->login($_POST['email'], $_POST['pass']);
		if($user->id) {
			$_SESSION['phlogger_user'] = $user;
		}		

	}

	// för att logga ut, sätt $user till false och förstör sessionen
	if($user && isset($_GET['logout'])) {
		
		$user->logout();
		
		session_destroy();

	}

	// Skapa ett Dashboard-objekt som håller allt lattjo
	$dashboard = new Dashboard($user);

	// dashboard eller login-formulär
	// är du inloggad kan du visa statistik eller skriva post...
	if($user && $user->id) {

		// om det ska sparas en post
		if(isset($_POST['save_blog_post'])) {
			$dashboard->createBlogPost($_POST);
		}

		// visa dashboard eller formulär för att skriva post

		// formulär
		if(isset($_GET['new'])) {

			$dashboard->setPage('write_blogpost.html');
			$dashboard->setTitle('Skriv nytt inlägg');

		}
		// dashboard
		else {

			$dashboard->setPage('dashboard.html');
			$dashboard->setTitle('Dashboard');			

		}

	}
	// ...annars får du inloggningsformulär
	else {

		$dashboard->setPage('login_form.html');
		$dashboard->setTitle('Logga in till Phlogger Admin');
	
	}

	// skapa twig-objekt
	$page = new Twig(['blog' => $dashboard]);
	//$page->addData($data);
	echo $page->render('index.html');
