<?php

	// klassen Home är den klass vi anropar om vår besökare inte har angett några underkategorier
	// dvs om hen besöker mycoolwebsite.com
	// då behöver vi en klass och en metod som hjälper oss visa vår startsida

	class Home {

		// en metod som anropas genom klassen och inte genom ett objekt måste vara "static", så vi anger det först
		// då kommer vi åt den genom att skriva Home::fallback
		// har man inte angett något annat är en metod "public", men vi skriver ut det ändå för att förtydliga
		static public function fallback() {

			// det enda vår metod fallback gör är att skapa två variabler i en array som skickas tillbaka till index.php
			// och sedan vidare in i Twig, och filen index.twig som anropas i index.php.
			// 'title' använder vi för att säga åt vår sida vad som ska stå i webbläsarens sidhuvud, dvs <title></title>
			// och 'page' anger vilken extra .twig-fil som vi ska läsa in i index.twig.
			// 'title' och 'page' är inte något speciellt eller nödvändigt egentligen, utan namn vi förutbestämt när vi skapade
			// vår index.twig.
			//
			// jag har lagt till en variabel som heter "info". där kan man skriva ett valfritt meddelande som sedan hämtas in i index.twig
			// med hjälp av den kan man se vilken klass och variabel som anropas. Där kan man skriva vad som helst egentligen...
			$output = [
			'title'	=> 'Välkommen',
			'page'	=> 'home.twig',
			'info'	=> 'Jag kom från metoden "fallback" i klassen Home'
			];

			// vi använder return så att vi kan lägga datan vi genererat i en variabel
			// i vår index.php-fil heter den variabeln $twig_data
			// return gör alltså att $twig_data "ärver" det som genereras i av den anropade metoden
			return $output;

		}

	}