<?php

class Ads {

	private $id, $title, $content, $dateCreated, $dateExpire, $userId, $imageName, $tags;

	function __construct($input) { //$input kommer från getAllAds eller getSpecificAd
		$this->id = $input['id'];
		$this->title = $input['title'];
		$this->content = $input['content'];
		$this->dateCreated = $input['date_created'];
		$this->dateExpire = $input['date_expire'];
		$this->userId = $input['user_id'];
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

	static public function fallback($input) {
		if (isset($input['id'])){ //annonsid
			return self::getSpecificAd($input['id']);
		} else { 
			return self::getAllAds($input);
		}
	}

	static public function getAllAds($input = FALSE) {
		if(isset($input['search'])) {
			$searchString = $input['search'];
			$sqlSearch = " AND ads.title LIKE '%".$searchString."%' OR ads.content LIKE '%".$searchString."%' ";	
		} else {
			$searchString = FALSE;
			$sqlSearch = "";
		}

		$data_array = DB::query(
			"SELECT ads.id as id, ads.title as title, ads.content as content, ads.date_created as date_created, ads.date_expire as date_expire, ads.user_id as user_id, user.address_zip as zipcode
			FROM ads, user 
			WHERE user.id = ads.user_id".$sqlSearch 
		);
		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		$output = [
		'ads' => $ads,
		'page' => 'ads.getallads.twig',
		'title' => 'Alla annonser',
		'search' => $searchString
		];

		return $output;
	}

	static public function getSpecificAd($id){
		$data = DB::query (
			"SELECT ads.id as id, ads.title as title, ads.content as content, ads.date_created as date_created, ads.date_expire as date_expire, user.id as user_id,  user.firstname as firstname, user.address_zip as zipcode
			FROM ads, user
			WHERE user.id = ads.user_id AND ads.id = $id", 
			TRUE
		);

		$ad = new Ads($data);

		$output = [
		'ad' => $ad,
		'page' => 'ads.getspecificad.twig',
		'title' => $ad->title
		];

		return $output;
	}

	static public function getUserAds($input = FALSE) {
		$user = User::isLoggedIn(); 

		$data_array = DB::query(
			"SELECT id, title, content, date_created, date_expire, user_id
			FROM ads
			WHERE user_id = ".$user->id
			);

		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		return $ads;
	}

	public static function newAdForm() {
		$user = User::isLoggedIn();

		$output = [
		'title' => 'Skapa ny annons', 
		'page' => 'ads.newadform.twig'
		];

		return $output;
	}

	public static function saveAd($input) {
		$user = User::isLoggedIn();

		$cleanData = DB::clean($input);

		$title = $cleanData['title'];
		$content = $cleanData['content'];
		$userId = $user->id;

		$sql = "INSERT INTO ads 
				(title, content, user_id)
				VALUES
				('$title', '$content', '$userId')
		";

		$data = DB::$con->query($sql);

		if($data) {
			header('Location: //'.ROOT.'/user');	
		} else {
			echo DB::$con->error; 
			die();
		}
	}

}