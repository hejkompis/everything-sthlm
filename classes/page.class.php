<?php

	class Page {

		static public function fallback() {

			$output = [
			'title'	=> ' - Välkommen',
			'page'	=> 'home.twig',
			'msg'	=> 'HELLO WORLD!'
			];

			return $output;

		}

	}