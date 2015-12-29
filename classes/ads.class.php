<?php

class Ads {

	private $id, $title, $content, $dateCreated, $userId, $imageName, $tags;
	static private $query; 

	function __construct() {

	}

	static public function getAllAds() {
		self::$query = DB::query(
			"SELECT title, text, date_created, user_id, address 
			FROM ads, user 
			WHERE user.id = ads.user_id" 
		);
	}

	static public function getSpecificAd($id){
		self::$query = DB::query (
			"SELECT title, text, date_created, firstname, address
			FROM ads, user
			WHERE user.id = ads.user_id AND ads.id = $id", 
			TRUE
		);
	}

	function createAd() {

	}
}