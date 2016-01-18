<?php

	class Home {

		static public function fallback() {

			$output = [
				'page' 				=> 'home.twig',
				'user' 				=> User::isLoggedIn(FALSE),
				'activeadsamount' 	=> self::getActiveAds(),
				'usersamount' 		=> self::getUsers(),
				'latestupload'		=> self::latestUploadedAd()
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
			$sql = "SELECT title as title
					FROM ads
					ORDER date_created DESC LIMIT BY 1
			";
			
			$data = DB::query($sql, TRUE);
			$output = $data['title'];

			return $output;
		}

	}