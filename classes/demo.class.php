<?php

	// den här klassen kommer vi åt genom att besöka mycoolwebsite.com/demo/
	// då kommer index.php leta efter en fil som heter demo.class.php i mappen /classes/
	// vill vi att man ska kunna besöka mycoolwebsite.com/demo/ utan en underkategori så måste vi ge klassen
	// en statisk och public metod som heter "fallback"

	class Demo {

		// vår metod "fallback" körs om besökaren går in på mycoolwebsite.com/demo/
		static public function fallback() {

			$output = [
			'title'	=> 'En titel från Demo-klassens fallback-metod',
			'page'	=> 'demo.fallback.twig',
			'info'	=> 'Jag kom från metoden "fallback" i klassen Demo'
			];

			return $output;

		}

		// den här metoden körs om besökaren går in på mycoolwebsite.com/someclass
		// det enda den gör är att anropa en annan metod i samma klass med hjälp av self::metodnamn och köra den
		static public function someclass() {

			return self::anotherclass();

		}

		// den här metoden körs i someclass, och det går utmärkt, men eftersom den är privat kan den
		// inte köras genom att besöka mycoolwebsite.com/anotherclass
		private function anotherclass() {

			$output = [
			'title'	=> 'Another Class',
			'page'	=> 'demo.anotherclass.twig',
			'info'	=> 'Jag finns i metoden "anotherclass" i klassen Demo, men ritades ut i metoden "someclass" i klassen Demo'
			];

			return $output;

		}

		// om du besöker sidan /demo/showmymessage/ och lägger till $_GET-variabeln "message"
		// typ /demo/showmymessage/?message=Hej! så kommer den här metoden att skriva ut "Hej!"
		// vi skickar med det som en variabel "message" till Twig
		static public function showmymessage($data) {

			// ?message går från att vara $_GET['message'] till $data['message'] när vi hämtar in det
			// genom vårt alias $data
			$message = $data['message'];

			$output = [
			'title'		=> 'Show my message',
			'page'		=> 'demo.showmymessage.twig',
			'info'		=> 'Jag finns i metoden "showmymessage" i klassen Demo',
			'message' 	=> $message
			];

			return $output;

		}

	}