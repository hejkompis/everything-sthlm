<?php
	class Login {
		/**
	     * Construct won't be called inside this class and is uncallable from
	     * the outside. This prevents instantiating this class.
	     * This is by purpose, because we want a static class.
	     */
		private static $instance, $query, $username, $password;
		private static $initialized = false;
	
		private function __construct() {}

		private static function initialize() {
	    	if (self::$initialized)
	    		return;

	        // self::$username = $_POST['username'];
			// self::$password = $_POST['password'];

			self::$initialized = true;
	    	
	    }

		public static function authenticateUser($username, $password) {

			self::initialize();
			self::$query = DB::query(
				"SELECT id, clearence 
			 	FROM user
			 	WHERE username = '$username' 
			 	AND password = '$password'"
			);
		}

		public static function initUserInstanceToSession() {
			switch (self::$query[0]['clearence']) {
			 	case 'admin':
			 		$_SESSION['user'] = new AdminUser($id);
			 		break;
			 	case 'free':
			 		$_SESSION['user'] = new FreeUser($id);
			 		break;
			 	case 'premium';
			 		$_SESSION['user'] = new PremiumUser($id);
			 		break;
			 	default:
			 		echo 'Sorry! You do not have clearence.';
			 		break;
			} ;
		}
	}