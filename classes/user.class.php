<?php

class User {

	private $id, 
			$firstName, 
			$lastName, 
			$email, 
			$phone, 
			$address_street, 
			$address_zip, 
			$address_city;

	private static $user = FALSE;

	function __construct($id){
		//$cleadId tvättas via clean() i DB-klassen. 
		$cleanId = DB::clean($id);
		$sql = "SELECT firstname, lastname, email, phone, address_street, address_zip, address_city
				FROM user
				WHERE id = ".$cleanId;

		//sql-frågan skickas iväg till databasen via DB-klassens query-metod.
		//TRUE skickas med för att vi bara får tillbaka en rad.
		//$data är en array som innehåller raden från databasen. 
		$data = DB::query($sql, TRUE);
		
		$this->id 				= $cleanId;
		$this->firstName 		= $data["firstname"];
		$this->lastName 		= $data["lastname"];
		$this->email 			= $data["email"];
		$this->phone 			= $data["phone"];
		$this->address_street 	= $data["address_street"];
		$this->address_zip 		= $data["address_zip"];
		$this->address_city 	= $data["address_city"];
	}

	//Om man inte har angett en metod i URL körs fallback-metoden.
	public static function fallback() { 
		return self::dashboard();		
 	}

 	//Magisk get för att Twig ska kunna komma åt privata properties i klassen.
	function __get($var) {
		if ($this->$var) {
			return $this->$var;
		}
	}

	//Magisk isset behövs för att Twig ska kunna använda magisk get.
	function __isset($var) { 
		if ($this->$var) {
			return TRUE; 
		}
		return FALSE; 
	}

	//Skriver ut formulär för att skapa ny användare
	public static function newUserForm() {
		$output = ['title' => 'Skapa användare', 'page' => 'user.newuserform.twig'];

		return $output;
	}

	//$input kommer från POST-fälten i user.newuserform.twig.
	public static function saveNewUser($input) {
		$cleanInput = DB::clean($input);

		$firstname 		= $cleanInput['firstname'];
		$lastname 		= $cleanInput['lastname'];
		$address_street = $cleanInput['address_street'];
		$address_zip 	= preg_replace("/[^0-9]/", "", $cleanInput['address_zip']);
		$address_city 	= $cleanInput['address_city'];
		$email 			= $cleanInput['email'];
		$scrambledPassword = hash_hmac("sha1", $cleanInput["password"], "dont put baby in the corner");
		
		$sql = "INSERT INTO user 
				(firstname, lastname, address_city, address_zip, address_street, email, password)
				VALUES
				('$firstname', '$lastname', '$address_city', '$address_zip', '$address_street', '$email', '$scrambledPassword')
		";

		$data = DB::query($sql);

		//Om vi har lyckats skapa en användare (lägga in denna i databasen) returneras $data som TRUE och 
		//användaren skickas till /user annars visas databaserror. 
		if($data) {
			header('Location: //'.ROOT.'/user');	
		}
	}

	public static function login($input){

		$cleanInput = DB::clean($input);
		$scrambledPassword = hash_hmac("sha1", $cleanInput["password"], "dont put baby in the corner");
		$sql = "SELECT id
				FROM user
				WHERE email = '".$cleanInput["email"]."'
				AND password = '".$scrambledPassword."'
				";
		//TRUE gör att man bara får tillbaka en rad
		$data = DB::query($sql, TRUE); 

		if($data){
			$_SESSION["everythingSthlm"]["userId"] = $data["id"];
			//Skapa en instans av User-klassen. Constructorn körs och hämtar info om användaren. 
			self::$user = new User($data["id"]);
		}

		//Detta görs för att vi måste ta vägen någonstans när vi har loggat in.
		header('Location: //'.ROOT.'/user'); 
	}

	//Kollar om användaren är inloggad eller inte. Om man är inloggad finns möjlighet att plocka ut 
	//användarobjektet annars skickas man t inloggningsformuläret. Elseif ska bara säga nej du är inte 
	//inloggad = får ej gå vidare i koden. 
	public static function isLoggedIn($sendToLogin = TRUE) {
		//Finns ingen användare och vi vill skicka anv. till login-form:
		if(!$_SESSION["everythingSthlm"]["userId"] && $sendToLogin) {
			header('Location: //'.ROOT.'/user/loginform'); exit;
		//Finns ingen anv. och $sendToLogin är FALSE	
		} elseif(!$_SESSION["everythingSthlm"]["userId"] && !$sendToLogin) {
			$output = FALSE;
		} else {
			$id = $_SESSION["everythingSthlm"]["userId"];
			if(!self::$user) {
				self::$user = new User($id);
			}

			$output = self::$user;
		}
		return $output;
	}

	//Skickar info så vi kan skriva ut loginformuläret.
	public static function loginForm() {
		$output = ['title' => 'Logga in', 'page' => 'user.loginform.twig'];

		return $output;
 	}

 	//Dashboard visas på /user. Här skickar vi med user-objekt och användarens annonser. 
 	public static function dashboard() { 
		$user = self::isLoggedIn(); 

		if($user) {
		
			$output = [
			'title' => 'Hej och välkommen '.$user->firstName.'!', 
			'page' 	=> 'user.dashboard.twig',
			'user' 	=> $user,
			'ads' 	=> Ads::getUserAds()
			];
		}
		else {
			$output = [
			'page' => 'home.twig'
			];
		}

		return $output;
 	}

 	//Loggar ut användaren.
 	public static function logOut() {

 		$_SESSION['everythingSthlm']['userId'] = FALSE;
 		self::$user = FALSE;

 		header('Location: //'.ROOT); 
 	}
}

