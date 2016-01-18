<?php

	class Home {

		static public function fallback() {

			$output = [
				'page' => 'home.twig',
				'user' => User::isLoggedIn(FALSE),
				'activeadsamount' => self::getActiveAds() 
			];

			return $output;
			//'usersamount' => self::getUsers()
		}

		static public function getActiveAds() {
			$sql = "SELECT COUNT(id)
					FROM ads
					WHERE active = 1
			"; 

			$data = DB::query($sql);

			$output = $data;

			return $output;
		}

		static public function getUsers() {

		}

	}