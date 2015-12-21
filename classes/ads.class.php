<?php

	class Ads {

		// $ads innehåller alla annonser i en array, läses in i funktionen listAds
		private static $ads = [];
		// variabler för att hålla information när man gör ett objekt av Ads
		private $id, $title, $text, $date, $location = [], $user_id;

		// när man skapar ett objekt av Ads sparar vi ner data i variablerna. vi sätter också lat/long som vi kommer jobba med först senare
		function __construct($data) {

			$this->id 		= $data['id'];
			$this->title 	= $data['title'];
			$this->text 	= $data['text'];
			$this->date 	= $data['date_updated'];
			$this->user_id 	= $data['user_id'];
			$this->location['longitude'] 	= $data['location_long'];
			$this->location['latitude'] 	= $data['location_lat'];

		}

		// fallback är funktionen som åkallas om det inte finns någon specifik funktion i URL ex. everythingsthlm.se/klassnamn/ (här saknas metodnamn) /
		public static function fallback() {

			// nu kör vi funktionen listAds här, direkt från klassen
			return self::listAds();

		}

		// metod för att hämta annoner, fungerar också för sök
		private static function listAds($tags = false, $searchstring = false) {

			// unix timestamp för just nu, att stämma av mot annonserna
			$now = time();

			// ska läggas till datumkoll på denna så att den inte hämtar annonser vars bäst-före-datum passerat, sorterar på date_updated utifall att någon förlängt sin annonstid, då ska den hamna överst igen (fick jag för mig...)
			$sql = "
			SELECT id, title, text, date_created, date_updated, location_lat, location_long, user_id 
			FROM ads
			ORDER BY date_updated DESC";
			// vi använder oss av klassen DB:s query-metod (den hämtar sig själv och körs om den inte existerat innan). Resultatet sparas ner i $ad_array
			$ad_array = DB::query($sql);

			// för varje rad i arrayen skapar vi ett nytt objekt och lägger det i variabeln $ads, som vi sen kommer åt genom Twig
			foreach($ad_array as $ad) {
				self::$ads[] = new Ads($ad);
			}

			// spara ner till Twig. Titel -> det som står i webbläsarfliken, Page -> vilken twig-fil som ska läsas in i index.twig (som alltid körs via index.php), Ads -> alla annonser som objekt i en lista
			$output = [
			'title' => 'Lista annonser',
			'page'	=> 'ads.twig',
			'ads'	=> self::$ads // här hämtar vi in annonserna via klassen, inte något objekt
			];

			// skicka ut allt i en variabel
			return $output;

		}

		// funktion för att rita ut ett objekt, behöver nog ett bättre namn
		public static function show($input) {

			// sqlfrågan
			$sql = "
			SELECT id, title, text, date_created, date_updated, location_lat, location_long, user_id 
			FROM ads
			WHERE id = ".$input['id'];
			// hämta via DB:s query-metod. När den sätts till TRUE hämtar den bara en rad ist för en array. Då behövs ingen while- eller foreach-loop.
			$ad_data = DB::query($sql, true);

			// spara ner till Twig. Titel -> det som står i webbläsarfliken, Page -> vilken twig-fil som ska läsas in i index.twig (som alltid körs via index.php), Ad -> annonsen som ett objekt
			$output = [
			'title' => $ad_data['title'],
			'page'	=> 'ad.twig',
			'ad'	=> new Ads($ad_data)
			];

			// skicka ut
			return $output;

		}

		// magic get
		public function __get($var) {

			if ($this->$var) {
				return $this->$var;
			}

		}

		// magic set
	    public function __isset($var) {

			if ($this->$var) {
				return true;
			}

			return false;
	    
	    }

	}