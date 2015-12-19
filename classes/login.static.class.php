<?php
	require_once('classes/db.class.php');

	class Login {
		private static $instance, $query, $username, $password;
	
		private function __construct() {
			self::$username = $_POST['username'];
			self::$password = $_POST['password'];

			self::$query = self::authenticateUser(self::$username, self::$password);
		}

		private static function getInstance() {
		
			if (self::$instance === null) {
				
				self::$instance = new Login();

			}
 
			return self::$instance;

		}

		private static function authenticateUser($username, $password) {

			self::getInstance();

			$query = DB::query(
				'SELECT username, firstname, lastname, id, clearence 
			 	FROM user
			 	WHERE username = $username 
			 	AND password = $password'
			);

			return $query;
		}

		private static function initUserInstance() {
			
		}
	}