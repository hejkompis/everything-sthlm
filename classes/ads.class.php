<?php

class Ads {

	private 	$id, 
				$title, 
				$content, 
				$dateCreated, 
				$dateExpire, 
				$userId, 
				$imageName, 
				$tags, 
				$type,
				$address_street,
				$address_zip,
				$address_city;

	function __construct($input) { //$input kommer från getAllAds eller getSpecificAd
		
		$this->id 				= $input['id'];
		$this->title 			= $input['title'];
		$this->content 			= $input['content'];
		$this->dateCreated 		= date('Y-m-d', $input['date_created']);
		$this->dateExpire 		= date('Y-m-d', $input['date_expire']);
		$this->userId 			= $input['user_id'];
		$this->type 			= $input['ad_type'];
		$this->address_street 	= $input['address_street'];
		$this->address_zip 		= $input['address_zip'];
		$this->address_city 	= $input['address_city'];
		$this->tags 			= self::getSpecificTags($this->id);

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
			return self::showSpecificAd($input);
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

		$sql = "SELECT ads.id as id, ads.title as title, ads.content as content, ads.date_created as date_created, ads.date_expire as date_expire, ads.user_id as user_id, ads.address_street as address_street, ads.address_zip as address_zip, ads.address_city as address_city, ads.ad_type as ad_type
			FROM ads, user 
			WHERE user.id = ads.user_id ".$sqlSearch. " AND date_expire >= ".time()."
			ORDER BY date_created DESC";
		
		$data_array = DB::query($sql);
		
		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		$output = [
		'ads' 		=> $ads,
		'page' 		=> 'ads.getallads.twig',
		'title' 	=> 'Alla annonser',
		'search' 	=> $searchString
		];

		return $output;
	}

	static public function getSpecificAd($input){
		
		$id = DB::clean($input['id']);

		$sql = 	"SELECT ads.id as id, ads.title as title, ads.content as content, ads.date_created as date_created, ads.date_expire as date_expire, user.id as user_id,  user.firstname as firstname, ads.address_street as address_street, ads.address_zip as address_zip, ads.address_city as address_city, ads.ad_type as ad_type 
				FROM ads, user
				WHERE user.id = ads.user_id AND ads.id = $id
				";
		
		$data = DB::query($sql, TRUE);

		$output = new Ads($data);
		
		return $output;
	}

	public static function showSpecificAd($input) {

		$ad = self::getSpecificAd($input);

		$output = [
		'ad' 	=> $ad,
		'page' 	=> 'ads.showspecificad.twig',
		'title' => $ad->title,
		'tags'	=> self::getAllTags()
		];
		
		return $output;

	}

	static public function getUserAds($input = FALSE) {
		$user = User::isLoggedIn(); 

		$sql = "SELECT id, title, content, date_created, date_expire, user_id, address_street, address_zip, address_city, ad_type
			FROM ads
			WHERE user_id = ".$user->id;

		$data_array = DB::query($sql);

		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		return $ads;
	}

	public static function newAdForm() {
		
		$user = User::isLoggedIn();
		$dateExpire = date('Y-m-d', time()+(60*60*24*7));

		$output = [
		'title' 		=> 'Skapa ny annons', 
		'page' 			=> 'ads.newadform.twig',
		'user' 			=> $user,
		'date_expire' 	=> $dateExpire,
		'tags'			=> self::getAllTags()
		];

		return $output;
	}

	public static function editAdForm($input) {
		
		$user = User::isLoggedIn();
		$ad = self::getSpecificAd($input);

		$output = [
		'title' 		=> 'Redigera annons', 
		'page' 			=> 'ads.editadform.twig',
		'user' 			=> $user,
		'ad' 			=> $ad,
		'tags'			=> self::getAllTags()
		];

		return $output;
	}

	public static function saveAd($input) {
		$user = User::isLoggedIn();

		$cleanInput = DB::clean($input);

		$title 			= $cleanInput['title'];
		$content 		= $cleanInput['content'];
		$address_street = $cleanInput['address_street'];
		$address_zip 	= preg_replace("/[^0-9]/", "", $cleanInput['address_zip']);
		$address_city 	= $cleanInput['address_city'];
		$date_expire 	= strtotime($cleanInput['date_expire']);
		$userId 		= $user->id;

		$ad_type		= $cleanInput['ad_type'];
		$date_created	= time();

		if(!isset($cleanInput['tags'])) {
			$tags = [];
		} else {
			$tags = $cleanInput['tags'];
		}

		// samma som ovan
		// $tags = isset($cleanInput['tags']) ? $cleanInput['tags'] : [];

		$sql = "INSERT INTO ads 
				(title, content, user_id, address_street, address_zip, address_city, date_expire, date_created, ad_type)
				VALUES
				('$title', '$content', '$userId', '$address_street', '$address_zip', '$address_city', '$date_expire', '$date_created', '$ad_type')
		";

		$data = DB::$con->query($sql);

		if($data) {

			// $con->insert_id är en inbyggd funktion som hämtar det senast sparade ID:t
			$ad_id = DB::$con->insert_id;
			
			foreach($tags as $tag_id) {
				$sql = "INSERT INTO ad_has_tag 
						(ad_id, tag_id) 
						VALUES 
						($ad_id, $tag_id)
						";

				DB::$con->query($sql);
			}

			$output = ['redirect_url' => '//'.ROOT.'/user'];
				
		} else {
			
			$output = ['error' => DB::$con->error];

		}

		return $output;

	}

	public static function updateAd($input) {
		$user = User::isLoggedIn();

		$cleanInput = DB::clean($input);

		$ad_id 			= $cleanInput['id'];
		$title 			= $cleanInput['title'];
		$content 		= $cleanInput['content'];
		$address_street = $cleanInput['address_street'];
		$address_zip 	= preg_replace("/[^0-9]/", "", $cleanInput['address_zip']);
		$address_city 	= $cleanInput['address_city'];
		$date_expire 	= strtotime($cleanInput['date_expire']);
		$userId 		= $user->id;

		$ad_type		= $cleanInput['ad_type'];

		if(!isset($cleanInput['tags'])) {
			$tags = [];
		} else {
			$tags = $cleanInput['tags'];
		}

		// samma som ovan
		// $tags = isset($cleanInput['tags']) ? $cleanInput['tags'] : [];

		$sql = 	"UPDATE ads SET
				title = '$title', 
				content = '$content',
				address_street = '$address_street',
				address_zip = '$address_zip',
				address_city = '$address_city',
				date_expire = '$date_expire',
				ad_type = '$ad_type'
				WHERE id = ".$ad_id;

		$data = DB::$con->query($sql);

		if($data) {

			$sql = "DELETE FROM ad_has_tag WHERE ad_id = ".$ad_id;
			DB::$con->query($sql);
			
			foreach($tags as $tag_id) {
				$sql = "INSERT INTO ad_has_tag 
						(ad_id, tag_id) 
						VALUES 
						($ad_id, $tag_id)
						";

				DB::$con->query($sql);
			}

			$output = ['redirect_url' => '//'.ROOT.'/user'];
				
		} else {
			
			$output = ['error' => DB::$con->error];

		}

		return $output;

	}

	public static function getAllTags() {

		$sql = "SELECT id, name FROM tags ORDER BY name";
		$output = DB::query($sql);

		return $output;

	}

	private static function getSpecificTags($ad_id) {

		$clean_ad_id = DB::clean($ad_id);

		$output = [];

		$sql = "SELECT tag_id FROM ad_has_tag WHERE ad_id = ".$clean_ad_id;
		$array = DB::query($sql);
		
		foreach($array as $data) {
			$output[] = $data['tag_id'];
		}

		return $output;

	}

}