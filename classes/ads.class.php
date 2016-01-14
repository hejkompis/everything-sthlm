<?php

class Ads {

	private 	$id, 
				$title, 
				$content, 
				$dateCreated,
				$createdDaysAgo, 
				$dateExpire, 
				$userId, 
				$imageName, 
				$tags, 
				$typeName,
				$typeId,
				$address_street,
				$address_zip,
				$address_city,
				$payment,
				$interested_users,
				$expireTimestamp,
				$active;

	//$input kommer från getAllAds, getSpecificAd eller getUserAds
	function __construct($input) { 
		
		$this->id 				= $input['id'];
		$this->title 			= $input['title'];
		$this->content 			= $input['content'];
		$this->dateCreated 		= date('Y-m-d', $input['date_created']);
		$this->dateExpire 		= date('Y-m-d', $input['date_expire']);
		$this->expireTimestamp	= $input['date_expire'];
		$this->userId 			= $input['user_id'];
		$this->typeId 			= $input['ad_type'];
		$this->typeName			= self::getSpecificAdType($this->id);
		$this->address_street 	= $input['address_street'];
		$this->address_zip 		= $input['address_zip'];
		$this->address_city 	= $input['address_city'];
		$this->tags 			= self::getSpecificTags($this->id);
		$this->createdDaysAgo	= round((time()-$input['date_created'])/60/60/24);
		$this->payment			= $input['payment'];
		$this->interested_users	= self::getInterestedUsers($this->id, $this->userId);
		$this->active 			= $this->checkActive($input['active']);
	
	}

	function __get($var) {
		if ($this->$var) {
			return $this->$var;
		}
	}

	//Behövs för att Twig ska kunna använda magisk get.
	function __isset($var) { 
		if ($this->$var) {
			return TRUE; 
		}
		return FALSE; 
	}

	//Körs om man inte har angett en specifik metod i URL.
	static public function fallback($input) { 
		if (isset($input['id'])){ //annonsid
			return self::showSpecificAd($input);
		} else { 
			return self::getAllAds($input);
		}
	}

	private function checkActive($active) {
		if ($active) {
			$output = TRUE;
			
			if ($this->expireTimestamp <= time()) {
				$this->active = FALSE;

				$sql = "UPDATE ads 
						SET active = '0'
						WHERE id = ".$this->id;

				DB::query($sql);
			}
		}
		else {
			$output = FALSE;
		}

		return $output;
	}

	//FALSE eftersom $input är valfri. Har ingen sökning skett visas alla Ads
	static public function getAllAds($input = FALSE) { 
	
		//Gör det möjligt att söka på Ads med fritext
		if(isset($input['search'])) {
			$searchString = DB::clean($input['search']);
			$searchString = strtolower($searchString);
			$sqlSearch = " AND (LOWER(ads.title) LIKE '%".$searchString."%' OR LOWER(ads.content) LIKE '%".$searchString."%') ";	
		} else {
			$searchString = FALSE;
			$sqlSearch = "";
		}

		//Gör det möjligt att söka på Ads med taggar
		if(isset($input['tags'])) {
			$searchTags = DB::clean($input['tags']);
			$sqlTags = " AND ads.id IN ( 
						SELECT DISTINCT(ad_id)
						FROM ad_has_tag
						WHERE ";
			foreach($searchTags as $searchTag) {
				$sqlTags .= "tag_id = $searchTag OR "; 
			}  

			$sqlTags = trim($sqlTags, "OR ");

			$sqlTags .= ")";

		} else {
			$searchTags = FALSE;
			$sqlTags = "";
		}

		//Gör det möjligt att söka på Adtype 
		if(isset($input['adtype']) && $input['adtype']!= "") {
			$searchAdType = DB::clean($input['adtype']);
			$sqlAdType = " AND ad_type = $searchAdType "; 

		} else {
			$searchAdType = FALSE;
			$sqlAdType = "";
		}

		$sql = "SELECT ads.id 		as id, 
				ads.title 			as title, 
				ads.content 		as content, 
				ads.date_created 	as date_created, 
				ads.date_expire 	as date_expire, 
				ads.user_id 		as user_id, 
				ads.address_street 	as address_street, 
				ads.address_zip 	as address_zip, 
				ads.address_city 	as address_city, 
				ads.ad_type 		as ad_type,
				ads.payment 		as payment,
				ads.active 			as active
			FROM ads, user 
			WHERE user.id = ads.user_id ".$sqlSearch.$sqlTags.$sqlAdType. " AND date_expire >= ".time()."
			ORDER BY date_created DESC";
		
		$data_array = DB::query($sql);
		
		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		$output = [
		'ads' 			=> $ads,
		'page' 			=> 'ads.getallads.twig',
		'title' 		=> 'Alla annonser',
		'search' 		=> $searchString,
		'tags'			=> self::getAllTags(),
		'searchTags'	=> $searchTags,
		'adTypes'		=> self::getAllAdTypes(),
		'user'			=> User::isLoggedIn(FALSE)
		];

		return $output;
	}

	//$input kommer utsprungligen från $GET 
	static public function getSpecificAd($input){ // 
		
		$id = DB::clean($input['id']);

		$sql = 	"SELECT ads.id 		as id, 
				ads.title 			as title, 
				ads.content 		as content, 
				ads.date_created 	as date_created, 
				ads.date_expire 	as date_expire, 
				user.id 			as user_id,
				user.firstname 		as firstname, 
				ads.address_street 	as address_street, 
				ads.address_zip 	as address_zip, 
				ads.address_city 	as address_city, 
				ads.ad_type 		as ad_type, 
				ads.payment 		as payment,
				ads.active 			as active 
				FROM ads, user
				WHERE user.id = ads.user_id AND ads.id = $id
				";

		//TRUE för att hämta en rad från DB
		$data = DB::query($sql, TRUE);

		$output = new Ads($data);
		
		return $output;
	}

	//Skickar getSpecificAd return till Twig 
	public static function showSpecificAd($input) {

		$ad = self::getSpecificAd($input);

		$output = [
		'ad' 			=> $ad,
		'page' 			=> 'ads.showspecificad.twig',
		'title' 		=> $ad->title,
		'tags'			=> self::getAllTags(),
		'user'			=> User::isLoggedIn(FALSE),
		'userInterest' 	=> self::checkInterest($ad->id, FALSE),
		'countInterest' => self::countUserInterest($ad->id)
		];
		
		return $output;
	}

	//Kollar först om man är inloggad, ifall inloggning är TRUE 
	//visas de anonnser som är skapade av den inloggade användaren
	static public function getUserAds($input = FALSE) {
		$user = User::isLoggedIn(); 

		$sql = "SELECT id, title, content, date_created, date_expire, user_id, address_street, address_zip, address_city, ad_type, payment, active
				FROM ads
				WHERE user_id = ".$user->id;

		$data_array = DB::query($sql);

		$ads = []; 
		foreach ($data_array as $data) {
			$ads[] = new Ads($data); 
		}

		return $ads;
	}

	//Om man är inloggad får man möjlighet att skapa ny annons 
	public static function newAdForm() {
		
		$user = User::isLoggedIn();
		$dateExpire = date('Y-m-d', time()+(60*60*24*7));

		$output = [
		'title' 		=> 'Skapa ny annons', 
		'page' 			=> 'ads.newadform.twig',
		'user' 			=> $user,
		'date_expire' 	=> $dateExpire,
		'tags'			=> self::getAllTags(),
		'ad_types'		=> self::getAllAdTypes()
		];

		return $output;
	}

	//Är man inloggad kan man redigera en annons. getSpecificAd() hämtar vald anonns och skriver ut dess
	//information i ett formulär i Twig
	public static function editAdForm($input) {
		
		$user = User::isLoggedIn();
		$ad = self::getSpecificAd($input);

		$output = [
		'title' 		=> 'Redigera annons', 
		'page' 			=> 'ads.editadform.twig',
		'user' 			=> $user,
		'ad' 			=> $ad,
		'tags'			=> self::getAllTags(),
		'ad_types'		=> self::getAllAdTypes()
		];

		return $output;
	}

	public static function activateAdForm($input) {
		
		$user = User::isLoggedIn();
		$ad = self::getSpecificAd($input);

		$output = [
		'title' 		=> 'Aktivera annons', 
		'page' 			=> 'ads.activateadform.twig',
		'user' 			=> $user,
		'ad' 			=> $ad,
		'tags'			=> self::getAllTags(),
		'ad_types'		=> self::getAllAdTypes()
		];

		return $output;
	}

	//Metod för att skapa ny annons
	public static function saveAd($input) {
		$user = User::isLoggedIn();

		$cleanInput = DB::clean($input);

		$title 			= $cleanInput['title'];
		$content 		= $cleanInput['content'];
		$address_street = $cleanInput['address_street'];
		$address_zip 	= preg_replace("/[^0-9]/", "", $cleanInput['address_zip']);
		$address_city 	= $cleanInput['address_city'];
		$date_expire 	= time()+(60*60*24*7);
		$userId 		= $user->id;
		$ad_type		= $cleanInput['ad_type'];
		$date_created	= time();
		$payment		= $cleanInput['payment'];

		if(!isset($cleanInput['tags'])) {
			$tags = [];
		} else {
			$tags = $cleanInput['tags'];
		}

		$sql = "INSERT INTO ads 
				(title, content, user_id, address_street, address_zip, address_city, date_expire, date_created, ad_type, payment)
				VALUES
				('$title', '$content', '$userId', '$address_street', '$address_zip', '$address_city', '$date_expire', '$date_created', '$ad_type', '$payment')
		";

		$data = DB::query($sql);

		if($data) {

			$ad_id = $data;
			
			// spara alla taggar som hör till annonsen
			foreach($tags as $tag_id) {
				$sql = "INSERT INTO ad_has_tag 
						(ad_id, tag_id) 
						VALUES 
						($ad_id, $tag_id)
						";

				DB::query($sql);
			}

			// spara ner att användaren har skapat en annons så vi kan räkna antalet annonser
			$sql = "INSERT INTO user_has_created_ads 
					(ad_id, user_id, date) 
					VALUES 
					($ad_id, $userId, $date_created)
					";

			DB::query($sql);

			$output = ['redirect_url' => '//'.ROOT.'/user'];
				
		} 

		return $output;
	}
	
	//$input = id för den annons som ska redigeras. 
	//Körs för för att spara den redigerade versionen av en anonns som har skpats i editAdForm()
	public static function updateAd($input) { 
		//Kollar först om användaren är inloggad.
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
		$payment		= $cleanInput['payment'];

		if(!isset($cleanInput['tags'])) {
			$tags = [];
		} else {
			$tags = $cleanInput['tags'];
		}

		// samma som ovan
		// $tags = isset($cleanInput['tags']) ? $cleanInput['tags'] : [];

		$sql = 	"UPDATE ads SET
				title 			= '$title', 
				content 		= '$content',
				address_street 	= '$address_street',
				address_zip 	= '$address_zip',
				address_city 	= '$address_city',
				date_expire 	= '$date_expire',
				ad_type 		= '$ad_type',
				payment			= '$payment'
				WHERE id = ".$ad_id;

		$data = DB::query($sql);

		if($data) {

			$sql = "DELETE FROM ad_has_tag 
					WHERE ad_id = ".$ad_id;
			
			DB::query($sql);
			
			foreach($tags as $tag_id) {
				$sql = "INSERT INTO ad_has_tag 
						(ad_id, tag_id) 
						VALUES 
						($ad_id, $tag_id)
						";

				DB::query($sql);
			}
			$output = ['redirect_url' => '//'.ROOT.'/user'];
				
		} 

		return $output;
	}

	public static function activateAd($input) {
		$user = User::isLoggedIn();

		$cleanInput = DB::clean($input);

		$ad_id = $cleanInput['id'];
		$date_expire = strtotime($cleanInput['date_expire']);

		$sql = "UPDATE ads 
				SET date_expire = '$date_expire', active = '1'
				WHERE id = ".$ad_id;

		DB::query($sql);

		$output = ['redirect_url' => '//'.ROOT.'/user/'];

		return $output;
						
	}

	public static function inactivateAd($input) {
		$user = User::isLoggedIn();

		$cleanInput = DB::clean($input);

		$id = $cleanInput['id'];

		$sql = "UPDATE ads 
				SET active = '0'
				WHERE id = ".$id;

		DB::query($sql);

		$output = ['redirect_url' => '//'.ROOT.'/user/'];

		return $output;
	}

	//Hämtar alla taggar från DB
	public static function getAllTags() {

		$sql = "SELECT id, name 
				FROM tags 
				ORDER BY name";

		$output = DB::query($sql);

		return $output;
	}

	//Hämtar taggar som är kopplade till en specifik annons
	private static function getSpecificTags($ad_id) {

		$clean_ad_id = DB::clean($ad_id);

		$output = [];

		$sql = "SELECT tag_id 
				FROM ad_has_tag 
				WHERE ad_id = ".$clean_ad_id;

		$array = DB::query($sql);
		
		foreach($array as $data) {
			$output[] = $data['tag_id'];
		}

		return $output;
	}

	//Är man inloggad kan 
	public static function deleteAd($input) {
		$user = User::isLoggedIn();
		$cleanId = DB::clean($input['id']);

		$sql = "DELETE FROM ads 
				WHERE id = $cleanId 
				AND user_id = ".$user->id;

		DB::query($sql);

		//Gör att man skickas vidare till den adressen som står efter =>
		//redirect_url finns i index.php-filen
		$output = ['redirect_url' => '/user/'];

		return $output;
	}	

	//Hämtar alla annonstyper
	private static function getAllAdTypes() {
		$sql = "SELECT id, name 
				FROM ad_types";

		$output = DB::query($sql);

		return $output;
	} 

	//Hämtar specifik adtype kopplad till vald annons
	private static function getSpecificAdType($id) {
		$cleanId = DB::clean($id);
		
		$sql = "SELECT ad_types.name as name 
				FROM ad_types, ads 
				WHERE ads.ad_type = ad_types.id 
				AND ads.id = $cleanId";
		
		$data = DB::query($sql, TRUE);
		$output = $data['name'];

		return $output;
	}

	// Metod för att kolla om en användare redan har intresse i en annons
	// För att en förändring inte ska ske i databasen utan att vi bara ska få tillbaka ett ja/nej
	// måste man ange FALSE-värde inom parenteserna, checkInterest($input, FALSE) annars kommer
	// metoden automatiskt att lägga till eller ta bort i databasen
	public static function checkInterest($input, $toggle = TRUE){

		// Skickar med FALSE för att inte skicka användaren till 
		// inloggningsformuläret
		$user = User::isLoggedIn(FALSE);

		if ($user) {

			if (is_array($input)) {
				$cleanAdId = DB::clean($input['id']);
				
			}
			else {
				$cleanAdId 	= DB::clean($input);
			}

			$userId 		= $user->id;
			$date 			= time();

			$sql = "
			SELECT * 
			FROM user_interested_in_ad
			WHERE ad_id = $cleanAdId
			AND user_id = $userId";

			$data = DB::query($sql, TRUE);

			// Om vi får tillbaka en rad från databasen (vilket gör $data till TRUE)
			if ($data) {

				// Om vi en rad från databasen och $toggle INTE är satt till FALSE
				if($toggle) {
					$sql = "
					DELETE 
					FROM user_interested_in_ad
					WHERE ad_id = $cleanAdId
					AND user_id = $userId";

					$data = DB::query($sql);
					$output = ['redirect_url'=>'/ads/?id='.$cleanAdId];
				} 

				// Om vi har en rad från databasen och $toggle MANUELLT är satt till FALSE
				// self::checkInterest($ad_id, FALSE)
				else {
					$output = TRUE;
				}

			} 

			// Om vi inte fått tillbaka någon rad från databasen, dvs användaren har inte visat intresse i en specifik annons
			else {

				// Om vi inte har någon rad och $toggle INTE är satt till FALSE ska vi lägga till en rad i databasen
				if($toggle) {
					$sql = "
					INSERT INTO user_interested_in_ad
					(ad_id, user_id, date)
					VALUES
					($cleanAdId, $userId, $date)";

					$data = DB::query($sql);
					$output = ['redirect_url'=>'/ads/?id='.$cleanAdId];
				} 

				// Om vi inte har någon rad och $toggle ÄR SATT till FALSE
				else {
					$output = FALSE;
				}
			}
		}

		else {
			$output = FALSE;
		}

		return $output;

	}

	private static function countUserInterest($adId) {
		//Kollar om anv är inloggad + skickar med FALSE för att inte skickas
		//direkt t loginformulär om man ej är det. 
		$user = User::isLoggedIn(FALSE);
		 
		if($user) { 

			$userId = $user->id;

			$sql = "
				SELECT COUNT(user_id) as count 
				FROM user_interested_in_ad
				WHERE ad_id = $adId 
				AND user_id != $userId
			";
			
			$data = DB::query($sql, TRUE); 

			$output = $data['count'];
		} else {
			$output = FALSE;
		}

		return $output;
	}

	//Hämta användare som är intresserad av en annons
	private static function getInterestedUsers($adId, $userId) {

		//Kollar först om anv är inloggad, om nej ska man inte bli skickad till loginfomulär därför skickas FALSE med.
		$user = User::isLoggedIn(FALSE);

		$cleanAdId = DB::clean($adId);
		$cleanUserId = DB::clean($userId);

		if($user && $user->id == $cleanUserId) {
			
			$sql = "
			SELECT user.firstname 	AS firstname, 
			user.lastname 			AS lastname, 
			user.email 				AS email
			FROM user, user_interested_in_ad
			WHERE user.id = user_interested_in_ad.user_id
			AND user_interested_in_ad.ad_id = ".$cleanAdId."
			ORDER BY user_interested_in_ad.date DESC
			";

			$data = DB::query($sql);

			$output = $data;
		} 
		else {	
			$output = FALSE;
		}

		return $output;
	}   

}