<?php

	class Home {

		static public function fallback() {

			$output = [
				'page' => 'home.twig',
				'user' => User::isLoggedIn(FALSE)
			];

			return $output;

		}

	}