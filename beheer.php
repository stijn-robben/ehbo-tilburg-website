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
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html" aria-label="To the homepage"><img src="./img/logo.png" width="70" height="auto" alt="Logo van EHBO Tilburg" /></a>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="lidmaatschap.html">
                        <p class="text-secondary text-nav">Lidmaatschap</p>
                    </a>

                    <li class="nav-item dropdown nav-link">
                        <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown" data-bs-toggle="dropdown">Opleidingen</a>
                        <div class="dropdown-menu">
                            <a href="activiteiten.html" class="dropdown-item text-secondary text-nav">
                                <p>Activiteiten</p>
                            </a>
                            <!-- <a href="#" class="dropdown-item text-secondary text-nav"><p>Item 2</p></a> -->
                        </div>
                    </li>

                    <a class="nav-link" href="wie-zijn-wij.html">
                        <p class="text-secondary text-nav">Wie zijn wij</p>
                    </a>
                    <a class="nav-link" href="hulpverlening.html">
                        <p class="text-secondary text-nav">Hulpverlening</p>
                    </a>
                    <li class="nav-item dropdown nav-link">
                        <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown" data-bs-toggle="dropdown">Overig</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item text-secondary text-nav">
                                <p>Item 1</p>
                            </a>
                            <a href="#" class="dropdown-item text-secondary text-nav">
                                <p>Item 2</p>
                            </a>
                            <a href="#" class="dropdown-item text-secondary text-nav">
                                <p>Item 3</p>
                            </a>
                        </div>
                    </li>

                    <a class="nav-link" href="contact.html">
                        <p class="text-secondary text-nav">Contact</p>
                    </a>
                    <div class="pt-2">
                        <a class="btn btn-secondary btn-lg" href="login.html" role="button">Inloggen</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
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
                            <form id="" class="" action="php/cursus-toevoegen.php" method="POST" role="form">
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
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 container">
        <div class="col-md-4 d-flex align-items-center mb-3 me-2 mb-md-0 lh-1">
            <a class="navbar-brand" href="#" aria-label="Back to the top of the page"><img src="./img/logo.png" width="50" height="auto" alt="Logo van EHBO Tilburg" /></a>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3">
                <a class="text-muted" href="#" aria-label="Link to our instagram page"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg></a>
            </li>
            <li class="ms-3">
                <a class="text-muted" href="#" aria-label="Link to our twitter page"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                    </svg></a>
            </li>
            <li class="ms-3">
                <a class="text-muted" href="#" aria-label="Link to our facebook page"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg></a>
            </li>
        </ul>
    </footer>

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