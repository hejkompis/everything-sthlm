<?php

class Ads {

	private $id, $title, $content, $dateCreated, $userId, $imageName, $tags;
	static private $query; 

	function __construct() {

	}

	static public function getAllAds() {
		
		self::$query = DB::query(
			"SELECT ads.title, ads.text, ads.date_created, ads.user_id, user.address_zip
			FROM ads, user 
			WHERE user.id = ads.user_id" 
		);

		$output = [
		'ads' => self::$query,
		'page' => 'ads.twig',
		'title' => 'Alla annonser'
		];

		return $output;

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