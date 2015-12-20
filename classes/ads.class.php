<?php

	class Ads {

		private static $ads = [];
		private $id, $title, $text, $date, $location = [], $user_id;

		function __construct($data) {

			$this->id 		= $data['id'];
			$this->title 	= $data['title'];
			$this->text 	= $data['text'];
			$this->date 	= $data['date_updated'];
			$this->user_id 	= $data['user_id'];
			$this->location['longitude'] 	= $data['location_long'];
			$this->location['latitude'] 	= $data['location_lat'];

		}

		public static function fallback() {

			return self::listAds();

		}

		// metod för att hämta annoner, fungerar också för sök
		private static function listAds($tags = false, $searchstring = false) {

			// unix timestamp för just nu, att stämma av mot annonserna
			$now = time();

			// ska läggas till datumkoll på denna
			$sql = "
			SELECT id, title, text, date_created, date_updated, location_lat, location_long, user_id 
			FROM ads
			ORDER BY date_updated DESC";
			$ad_array = DB::query($sql);

			foreach($ad_array as $ad) {
				self::$ads[] = new Ads($ad);
			}

			$output = [
			'title' => 'Lista annonser',
			'page'	=> 'ads.twig',
			'ads'	=> self::$ads
			];

			return $output;

		}

		public static function show($input) {

			$sql = "
			SELECT id, title, text, date_created, date_updated, location_lat, location_long, user_id 
			FROM ads
			WHERE id = ".$input['id'];
			$ad_data = DB::query($sql, true);

			$output = [
			'title' => $ad_data['title'],
			'page'	=> 'ad.twig',
			'ad'	=> new Ads($ad_data)
			];

			return $output;

		}

		public function __get($var) {

			if ($this->$var) {
				return $this->$var;
			}

		}

	    public function __isset($var) {

			if ($this->$var) {
				return true;
			}

			return false;
	    
	    }

	}