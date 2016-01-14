 <?php

    # -- 1

    // vi aktiverar session_start så att vi kan använda oss av $_SESSION om vi vill
    session_start();
    # -- 2

    // skapa en konstant som heter ROOT. På så sätt kan vi alltid veta vilken som är vår huvudadress, exempelvis 192.168.1.33 eller everythingsthlm.se
    define('ROOT', $_SERVER['HTTP_HOST']);

    # -- 3

    // om sidan försöker hämta en klass, direkt mot klassen Klass::metod eller genom att skapa ett objekt av en klass, $var = new Klass
    // så känner den magiska metoden __autoload av det. $class_name är ett alias för klassnamnet med hjälp av vilket vi kan läsa in rätt fil så vi kommer åt klassen. 
    // detta förutsätter att filen i vårt fall heter klassnamnet.class.php och ligger i mappen /classes/
    // vi använder också strtolower (som gör alla stora bokstäver till små) eftersom vår klass heter med stor bokstav och filen med liten bokstav.
    function __autoload($class_name) {
        require_once('classes/'.strtolower($class_name).'.class.php');
    }

    # -- 4

    // vi skapar en tom array som heter $twig_data, vilket är variabeln vi läser in i twig. det gör vi utifall att metoden vi kommer anropa inte skickar med någon data.
    // på så sätt skickar vi åtminstone med en tom array in och slipper få ett felmeddelande.
    $twig_data = [];

    # -- 5

    // vi skapar också en tom $data-variabel. $data-variablen skickar vi med in i metoden vi anropar så den har något att arbeta med. 
    // vi kommer strax leta efter mer data att stoppa in i denna, utifrån $_GET- och $_POST-variabler, men om det inte finns något så kommer det åtminstone med en tom variabel in och vi slipper felmeddelande.
    $data = false;

    # -- 6

    // nu ska vi hitta en klass och en metod att anropa för att hämta rätt twig-fil och rätt data.
    // det sker genom att läsa av vilken url-adress som står uppe i webbläsarens fönster.
    // det är filen .htaccess som gör om det som står i webbläsarfönstret till hanterbara variabler
    // den omvandlar det efter första / till en $_GET-variabel med nyckel "class" ($_GET['class']) och andra / till en $_GET-variabel med nyckeln "method" ($_GET['method']).
    // adressen mywebsite.com/awesome/stuff omvandlas alltså till att anropa klassen
    // Awesome i filen /classes/awesome.class.php och metoden stuff() i klassen Awesome
    // finns det ingenting efter första / så måste vi berätta för sidan vilken klass som ska användas
    // finns det ingeting efter andra / så måste vi berätta för sidan vilken metod som ska användas

    // här kollar vi om .htaccess hittat mycoolwebsite.com/someclass/ och omvandlat det till $_GET['class'] == "somemethod"
    // det räcker att kolla om $_GET['class'] existerar, det gör den bara om den hittat nåt.
    // om $_GET['class'] existerar sätter vi igång och kollar vad mer som finns.
    // om $_GET['class'] INTE existerar hoppar vi i stället vidare till punkt # 7 nedan
    if(isset($_GET['class'])) {

        # -- 6.1

        // om sidan hittat en $_GET['class'] så vet vi att det finns data att läsa av i $_GET-variabeln.
        // då gör vi om den till ett mer lättförståeligt namn så vi kan kolla vilken mer data som finns
        // att använda oss av
        $get_array = $_GET;

        # -- 6.2

        // vi vet ju att det åtminstone finns en variabet $_GET['class']
        // vi gör om den till en mer lättläst variabel, sen tar vi bort den ur $_GET med hjälp av unset()
        // de $_GET-variabler som blir kvar när vi letat upp klass och metod ska skickas med in som data i metoden,
        // förmodligen behövs de på något sätt. vi skulle kunna skicka med $_GET['class'] och $_GET['method'] också
        // men det tillför inget, så det är bättre att ta bort dem, därav unset().
        $class = $_GET['class'];
        unset($_GET['class']);

        # -- 6.3

        // vi kollar om .htaccess har läst av något efter ett andra / (mycoolwebsite.com/someclass/somemethod) och
        // då gjort om det till $_GET['method'] == "somemethod"
        // har den det gör vi om den till en enklare variabel och tar bort den ur $_GET-arrayen, pga samma skäl som vi tar bort $_GET['class']
        // hittar vi ingen $_GET['method'] hoppar vi vidare till # 6.4
        if(isset($_GET['method'])) {

            // vi omvandlar $_GET['method'] till $method, mer lättläst, samt att vi tar bort den ur $_GET-arrayen
            // kvar efter detta är nu bara det $_GET-variabler som vi vill skicka med in i metoden som data.
            $method = $_GET['method'];
            unset($_GET['method']);

        }

        # -- 6.4

        // om det inte finns en $_GET['method'] betyder det att vi inte kan läsa ut en metod att använda på dynamisk väg
        // då måste vi berätta för vår index.php-fil vilken metod som ska anropas, så att den vet hur den ska bete sig.
        // i det här fallet säger vi att den ska leta efter en metod som heter "fallback"
        else {

            $method = 'fallback';

        }

        # -- 6.5

        // vi kollar om det finns något kvar i $_GET-variabeln efter att vi tagit bort $_GET['class'] och $_GET['method']
        // detta gör vi genom att ställa en ja/nej fråga och ge variabeln data utifrån detta
        // i det här fallet frågar vi om $_GET fortfarande existerar, med hjälp av isset($somevariable).Om $_GET['class'] och $_GET['method'] var de enda två som fanns så slutar den existera när vi tar bort de båda.
        // om påståendet är sant så görs det som står direkt efter ?
        // vilket gör att $get_data blir en kopia av $_GET
        // annars blir $get_data = false
        $get_data = isset($_GET) ? $_GET : false;

        # -- 6.6

        // det kan vara så att vi postat ett formulär med POST, och då vill vi skicka med datan från formuläret in i vår metod
        // därför gör vi samma koll efter $_POST-data som vi nyss gjort efter $_GET-data
        // finns det $_POST-variabler blir $post_data en kopia av det, annars blir den false
        $post_data = isset($_POST) ? $_POST : false;

        # -- 6.7

        // vi kombinerar ihop eventuella $_GET-variabler ($get_data) och $_POST-variabler ($post_data) till en enda variabel med hjälp av funktionen array_merge, 
        // den bakar ihop båda till en $data-variabel
        $data = array_merge($get_data, $post_data);

    }

    # -- 7

    // om .htaccess inte hittar en $_GET['class'], vilket med största sannolikhet innebär adressen i webbläsaren bara är huvudadressen (mycoolwebsite.com), utan några /undersidor/, 
    // så måste vi ha en klass och metod att falla tillbaka på, så att index.php har något att arbeta med
    // i det här fallet har vi valt att använda klassen "Home" och metoden "fallback" som får äran att rita ut vår startsida
    else {

        $class = 'home';
        $method = 'fallback';

    }

    # -- 8

    // eftersom vår klass alltid heter något med stor bokstav först använder vi oss av funktionen ucfirst(),
    // vilken gör om först bokstaven i vår sträng och gör den stor. "class" blir alltså "Class"
    $class = ucfirst($class);

    # -- 9

    // nu är det dags att hämta den data som ska ritas ut i Twig, och det gör vi genom att anropa en metod i en klass, och skicka med vår data in i den
    // vi har under tidigare punkter fått fram en klass i variabeln $class, en metod i variabeln $method, och den data som ska skickas med i variabeln $data
    // när vi kombinerar ihop dessa får vi fram $class::$method($data), vilket blir ett alias för Klass::metod(data)
    // om adressen i webbläsarfönstret är mycoolwebsite.com/awesomeclass/nicemethod/?somekey=somestring
    // blir $class::$method($data) ett alias för Awesomeclass::nicemethod($somekey)
    // vi utgår från att vår metod returnerar någon form av innehåll, så vi lägger in det i variabeln $twig_data som sen läses in i Twig
    $twig_data = $class::$method($data);

    # 9.1

    if(isset($twig_data['redirect_url'])) { 
        header('Location: '.$twig_data['redirect_url']); 
    }

    # 9.2

    if(isset($twig_data['error'])) { 
        echo $twig_data['error']; 
    }

    # -- 10

    // vi skapar ett nytt twig-objekt. det här behövs egentligen inte. Tops lade allt som hade med Twig att göra direkt i index.php, men jag tycker det blir
    // lättöverskådligt och hanterbart på det här sättet
    // variabeln $page innehåller vår twig-data och vi renderar twig-filen index.twig som får äran att hantera all vår data
    // behöver vi ytterligare twig-filer så får metoden säga till om det, och de hämtas in via $twig_data
    $page = new Twig($twig_data);
    echo $page->render('index.twig');
