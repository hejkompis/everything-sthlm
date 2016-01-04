<?php

class User {

	private $id, $firstName, $lastName, $email, $phone, $address_street, $address_zip, $address_city;
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

	public static function fallback() {
		return self::dashboard();		
 	}

	function __get($var) {
		if ($this->$var) {
			return $this->$var;
		}
	}

	function __isset($var) { //behövs för att Twig ska kunna använda magisk get.
		if ($this->$var) {
			return TRUE; 
		}
		return FALSE; 
	}


	public static function login($input){
		$cleanInput = DB::clean($input);
		$scrambledPassword = hash_hmac("sha1", $cleanInput["password"], "dont put baby in the corner");
		$sql = "SELECT id
				FROM user
				WHERE email = '".$cleanInput["email"]."'
				AND password = '".$scrambledPassword."'
				";
		$data = DB::query($sql, TRUE); //TRUE gör att man bara får tillbaka en rad

		ech;

		if($data){
			$_SESSION["everythingSthlm"]["userId"] = $data["id"];
			self::$user = new User($data["id"]);
		}
		
		header('Location: //'.ROOT.'/user'); //Detta görs för att när vi har loggat in måste vi ta vägen någonstans.
	}

	public static function isLoggedIn() {
		if(!$_SESSION["everythingSthlm"]["userId"]) {
			header('Location: //'.ROOT.'/user/loginform');
		} else {
			$id = $_SESSION["everythingSthlm"]["userId"];
			if(!self::$user) {
				self::$user = new User($id);
			}

			return self::$user;
		}
	}

	public static function loginForm() {
		$output = ['title' => 'Logga in', 'page' => 'user.loginform.twig'];

		return $output;
 	}

 	public static function dashboard() { 
		$user = self::isLoggedIn(); 
		$output = [
		'title' => 'Hej och välkommen '.$user->firstName.'!', 
		'page' => 'user.dashboard.twig',
		'user' => $user,
		'ads' => Ads::getUserAds()
		];

		return $output;
 	}

 	public static function logOut() {

 		$_SESSION['everythingSthlm']['userId'] = FALSE;
 		self::$user = FALSE;

 		self::isLoggedIn();

 	}




}

