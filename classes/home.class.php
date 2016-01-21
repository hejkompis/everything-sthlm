<?php

	class Home {

		static public function fallback() {

			$output = [
				'page' 				=> 'home.twig',
				'user' 				=> User::checkLoginStatus(FALSE),
				'activeAdsAmount' 	=> self::getActiveAds(),
				'usersAmount' 		=> self::getUsers(),
				'latestUpload'		=> self::latestUploadedAd()
			];

			return $output;
			
		}

		static private function getActiveAds() {
			$sql = "SELECT COUNT(id) as count
					FROM ads
					WHERE active = 1
			"; 

			$data = DB::query($sql, TRUE);

			$output = $data['count'];

			return $output;
		}

		static private function getUsers() {
			$sql = "SELECT COUNT(id) as count
					FROM user
			";

			$data = DB::query($sql, TRUE);
			$output = $data['count'];

			return $output;
		}

		static private function latestUploadedAd() {
			$sql = "SELECT title as title, id
					FROM ads
					WHERE active = 1
					ORDER by date_created DESC
					LIMIT 1
			";
			
			$data = DB::query($sql, TRUE);
			$output = $data;

			return $output;
		}

		static public function premiumPage () {

			$output = [
			'page' => 'premium.twig', 
			'browserTitle' => 'Bli premiumanvändare'
			];

			return $output;
		}

	}