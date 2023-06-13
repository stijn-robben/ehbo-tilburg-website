<?php
session_start();

// Connect to the database
$host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
$port = 25060;
$user = 'Knv-ehbo-tilburg';
$pass = '3HBO!';
$dbname = 'Knv-ehbo-tilburg';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Fetch courses from the database
$queryPart1 = "SELECT * FROM content WHERE page = 'wie_zijn_wij' AND part = 1;";
$resultPart1 = mysqli_query($conn, $queryPart1);

// Generate HTML for content
$contentHTML = "";
if ($resultPart1->num_rows > 0) {
    while ($row = $resultPart1->fetch_assoc()) {
        $title = $row["title"];
        $text = $row["text"];
        $img_url = $row["img_url"];

        $contentHTML .= '<div class="jumbotron bg-jumbotron">
        <div class="container">
            <p class="jumbotron-head h2-secondary">' . $title . '</p>
            <p class="jumbotron-text">' . $text . '</p>
        </div>
    </div>';
    }
}




// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Website van KNV EHBO Tilburg." />
    <meta name="robots" content="index, follow" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="icon" type="image/x-icon" href="/img/s.png" />
    <script defer src="./js/script.js"></script>
    <title>EHBO Tilburg - Wie zijn wij</title>
</head>

<body class="bg-light">
    <!--Navbar-->
    <div id="navbar-placeholder"></div>

    <!-- Ga terug button -->
    <div class="d-none d-lg-block">
        <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
    </div>

    <!--Wie zijn wij?-->
    <?php echo $contentHTML; ?>

    <!--Team-->
    <div class="container pb-3">
        <div class="pt-2">
            <p class="h2-main">Team</p>
            <div class="card pt-1">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Johan Smarius</h4>
                                <p class="card-text text-center">voorzitter@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">
                                    Mijn naam is Johan Smarius, ik ben getrouwd en ik heb twee dochters. Overdag
                                    werk ik als software ontwikkelaar met als specialisme Microsoft technologie.
                                    In 2003 kon ik bij mijn vorige werkgever een cursus eerste hulp volgen. Na
                                    de cursus vond ik eerste hulp zo leuk dat ik sinds die tijd ook als
                                    vrijwilliger betrokken ben bij hulpverleningen bij evenementen. Tijdens
                                    evenementen en ook in de privésituatie heb ik al vaak hulp moeten verlenen
                                    en heb ik het belang van een goede opleiding ervaren. Sinds 2007 ben ik ook
                                    vrijwilliger geworden bij de Snel Inzetbare Groep Ter Medische Assistentie
                                    (SIGMA). In 2011 ben ik geslaagd als instructeur eerste hulp en geef ik les
                                    bij onder andere deze vereniging en het Rode Kruis afdeling Tilburg.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Anneke Heesters</h4>
                                <p class="card-text text-center">secretariaat@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">
                                    Mijn naam is Anneke Heesters, ik ben getrouwd en heb 4 kinderen, waarvan de
                                    oudste ook het EHBO diploma heeft behaald. Ik werk 3 dagen in de week als
                                    wijk/instructieverpleegkundige in een zorgcentrum voor verstandelijk
                                    gehandicapten. Mede daardoor vind ik het belangrijk om actief met de EHBO
                                    bezig te zijn en te blijven. In het voorjaar van 2000 ben ik benaderd om
                                    bestuurslid te worden. Ik heb "ja" gezegd omdat ik het leuk vind om over
                                    EHBO-zaken mee te denken. Op deze manier geef ik een gedeelte van mijn vrije
                                    tijd aan de vereniging.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Ineke Kuijer</h4>
                                <p class="card-text text-center">hulpverlening@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">Nadere gegevens worden nog toegevoegd.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Anita Joosen</h4>
                                <p class="card-text text-center">algemeen@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">Nadere gegevens worden nog toegevoegd.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Cees de Beer</h4>
                                <p class="card-text text-center">webmaster@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">
                                    Cees de Beer, geboren op 30 juni 1949, gehuwd, 2 zonen en 3 kleinkinderen.
                                    Na lange tijd allerlei functies te hebben uitgeoefend binnen de vereniging
                                    heb ik mijn activiteiten teruggebracht tot het bijhouden van de website en
                                    af en toe wat foto's maken tijdens de cursussen en de hulpverlening.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="./img/person.jpg" width="100%" class="rounded-3" alt="Afbeelding van" />
                            </div>
                            <div class="col-md-10">
                                <h4 class="card-title text-center">Manuela Smarius</h4>
                                <p class="card-text text-center">algemeen@ehbo-tilburg.nl</p>
                                <p class="card-text text-center">Nadere gegevens worden nog toegevoegd.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--Footer-->
    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>