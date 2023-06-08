<?php

session_start();

// $logFile = 'log.txt'; // File path for the log file

// $logMessage = "before isset loggedin\n";
// file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);


// file_put_contents($logFile, $_SESSION['loggedin'] . PHP_EOL, FILE_APPEND);

// file_put_contents($logFile, "\n" . PHP_EOL, FILE_APPEND);


// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.html");
    exit(); // Stop further execution of the code
}

// file_put_contents($logFile, "before session role\n" . PHP_EOL, FILE_APPEND);
// file_put_contents($logFile, "{$_SESSION['role']}" . PHP_EOL, FILE_APPEND);


// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['role'])) {
    echo "inside of isset role";
    echo $_SESSION['role'];
    // Controleer of de gebruiker is ingelogd als admin
    if ($_SESSION['role'] === 'admin') {
        // Gebruiker is ingelogd als admin, toon de beheerpagina
        $message = "admin is role";
        echo $message ;
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
    <title>EHBO Tilburg - Beheer</title>
</head>

<body class="bg-light">
    <!--Navbar-->
    <div id="navbar-placeholder"></div>
    
    <!--Beheer-->
    <div class="jumbotron bg-jumbotron">
        <div class="container">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Beheer</p>
            </div>
            <!-- Cursus toevoegen button -->
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#cursusToevoegenModal">
                Cursus toevoegen
            </button>

            <!-- Modal -->
            <div class="modal fade" id="cursusToevoegenModal" tabindex="-1" aria-labelledby="cursusToevoegenModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-secondary" id="cursusToevoegenModalLabel">Cursus toevoegen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Cursus toevoegen form -->
                            <form id="" class="" action="cursus-toevoegen.php" method="POST" role="form">
                                <div class="form-group">
                                    <label class="form-label text-secondary" for="date">Datum:</label>
                                    <input type="date" id="date" class="form-control popup-form" name="date" required /><br /><br />
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-secondary" for="subject">Onderwerp:</label>
                                    <input type="text" id="subject" class="form-control popup-form" name="subject" required /><br /><br />
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-secondary" for="keywords">Competenties:</label>
                                    <input type="text" id="keywords" class="form-control popup-form" name="keywords" required /><br /><br />
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-secondary" for="enrollments">Maximum aantal inschrijvingen:</label>
                                    <input type="number" id="enrollments" class="form-control popup-form" name="enrollments" required /><br /><br />
                                </div>
                                <div class="btn-message pt-3">
                                    <button class="pt-2 btn btn-secondary btn-lg" type="submit" name="submit">Cursus toevoegen</button>
                                </div>
                            </form>
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

<?php
        exit(); // Stop de verdere uitvoering van de code
    }
}
// file_put_contents($logFile, "sesion is not set" . PHP_EOL, FILE_APPEND);

// Gebruiker is niet ingelogd als admin of niet ingelogd, doorverwijzen naar de login-pagina
header("Location: login.html");
exit();

?>