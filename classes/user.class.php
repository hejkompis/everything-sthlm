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
		$cleanId = DB::clean($id);
		$sql = "SELECT firstname, lastname, email, phone, address_street, address_zip, address_city
				FROM user
				WHERE id = ".$cleanId;

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

	//om man inte angett en metod körs fallback.
	public static function fallback() { 
		return self::dashboard();		
 	}

	function __get($var) {
		if ($this->$var) {
			return $this->$var;
		}
	}

	//behövs för att Twig ska kunna använda magisk get.
	function __isset($var) { 
		if ($this->$var) {
			return TRUE; 
		}
		return FALSE; 
	}

	public static function newUserForm() {
		$output = ['title' => 'Skapa användare', 'page' => 'user.newuserform.twig'];

		return $output;
	}

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

		$data = DB::$con->query($sql);

		if($data) {
			header('Location: //'.ROOT.'/user');	
		} else {
			echo DB::$con->error; 
			die();
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
			self::$user = new User($data["id"]);
		}

		//Detta görs för att vi måste ta vägen någonstans när vi har loggat in.
		header('Location: //'.ROOT.'/user'); 
	}

	public static function isLoggedIn($sendToLogin = TRUE) {
		if(!$_SESSION["everythingSthlm"]["userId"] && $sendToLogin) {
			header('Location: //'.ROOT.'/user/loginform'); exit;
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

	public static function loginForm() {
		$output = ['title' => 'Logga in', 'page' => 'user.loginform.twig'];

		return $output;
 	}

 	public static function dashboard() { 
		$user = self::isLoggedIn(); 
		
		$output = [
		'title' => 'Hej och välkommen '.$user->firstName.'!', 
		'page' 	=> 'user.dashboard.twig',
		'user' 	=> $user,
		'ads' 	=> Ads::getUserAds()
		];

		return $output;
 	}

 	public static function logOut() {

 		$_SESSION['everythingSthlm']['userId'] = FALSE;
 		self::$user = FALSE;

 		self::isLoggedIn();
 	}
}

