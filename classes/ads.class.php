<?php

class Ads {

	private $id, $title, $content, $dateCreated, $userId, $imageName, $tags;

	function __construct() {

	}

	function getAllAds() {
		$query = DB::query(
			"SELECT title, text, date_created, user_id, address 
			FROM ads, user 
			WHERE user.id = ads.user_id" 
		);
	}

	function getSpecificAd(){

	}

	function createAd() {

	}
}