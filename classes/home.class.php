<?php

	class Home {

		static public function fallback() {

			return Ads::getAllAds();

		}

	}