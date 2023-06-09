<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // User is not logged in, redirect to the login page
    header("Location: inloggen.php");
    exit();
}

if (isset($_SESSION['role'])) {
    // Controleer of de gebruiker is ingelogd als admin
    if ($_SESSION['role'] === 'admin') {
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

                    <!-- Modal Cursus toevoegen -->
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
                                            <label class="form-label text-secondary" for="max_enrollments">Maximum aantal
                                                inschrijvingen:</label>
                                            <input type="number" id="max_enrollments" class="form-control popup-form" name="max_enrollments" required /><br /><br />
                                        </div>
                                        <div class="btn-message pt-3">
                                            <button class="pt-2 btn btn-secondary btn-lg" type="submit" name="submit">Cursus
                                                toevoegen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Evenement toevoegen button -->
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#evenementToevoegenModal">
                        Evenement toevoegen
                    </button>

                    <!-- Modal Evenement toevoegen -->
                    <div class="modal fade" id="evenementToevoegenModal" tabindex="-1" aria-labelledby="evenementToevoegenModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-secondary" id="evenementToevoegenModalLabel">Evenement toevoegen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Evenement toevoegen form -->
                                    <form id="" class="" action="evenement-toevoegen.php" method="POST" role="form">
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="name">Naam:</label>
                                            <input type="text" id="name" class="form-control popup-form" name="name" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="location">Locatie:</label>
                                            <input type="text" id="location" class="form-control popup-form" name="location" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="date">Datum:</label>
                                            <input type="date" id="date" class="form-control popup-form" name="date" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="start_time">Starttijd:</label>
                                            <input type="time" id="start_time" class="form-control popup-form" name="start_time" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="end_time">Eindtijd:</label>
                                            <input type="time" id="end_time" class="form-control popup-form" name="end_time" required /><br /><br />
                                        </div>
                                        <div class="btn-message pt-3">
                                            <button class="pt-2 btn btn-secondary btn-lg" type="submit" name="submit">Evenement toevoegen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content aanpassen button -->
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#contentAanpassenModal">
                        Content aanpassen
                    </button>

                    <!-- Modal Content aanpassen -->
                    <div class="modal fade" id="contentAanpassenModal" tabindex="-1" aria-labelledby="contentAanpassenModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-secondary" id="contentAanpassenModalLabel">Content aanpassen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Content aanpassen form -->
                                    <form id="" class="" action="content-aanpassen.php" method="POST" role="form">
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="page">Pagina:</label>
                                            <select id="page" class="form-control popup-form" name="page" required>
                                                <option value="homepage">Homepage</option>
                                                <option value="lidmaatschap">Lidmaatschap</option>
                                                <option value="activiteiten">Activiteiten</option>
                                                <option value="wie-zijn-wij">Wie zijn wij</option>
                                                <option value="hulpverlening">Hulpverlening</option>
                                                <!-- Voeg andere pagina-opties toe indien nodig -->
                                            </select><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="part">Onderdeel:</label>
                                            <select id="part" class="form-control popup-form" name="part" required>
                                                <option value="1">Onderdeel 1</option>
                                                <option value="2">Onderdeel 2</option>
                                                <option value="3">Onderdeel 3</option>
                                                <!-- Voeg andere onderdeel-opties toe indien nodig -->
                                            </select><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="title">Titel:</label>
                                            <input type="text" id="title" class="form-control popup-form" name="title" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="text">Tekst:</label>
                                            <textarea id="text" class="form-control popup-form" name="text" rows="8" required></textarea><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="img_url">Afbeeldings-URL:</label>
                                            <input type="text" id="img_url" class="form-control popup-form" name="img_url" required /><br /><br />
                                        </div>
                                        <div class="btn-message pt-3">
                                            <button class="pt-2 btn btn-secondary btn-lg" type="submit" name="submit">Content
                                                toevoegen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content toevoegen button -->
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#teamAanpassenModal">
                        Team aanpassen
                    </button>

                    <!-- Modal Team aanpassen -->
                    <div class="modal fade" id="teamAanpassenModal" tabindex="-1" aria-labelledby="teamAanpassenModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-secondary" id="teamAanpassenModalLabel">Team aanpassen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Team aanpassen form -->
                                    <form id="" class="" action="team-aanpassen.php" method="POST" role="form">
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="id_team">Teamlid:</label>
                                            <select id="id_team" class="form-control popup-form" name="id_team" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <!-- Voeg andere pagina-opties toe indien nodig -->
                                            </select><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="name">Name:</label>
                                            <input type="text" id="name" class="form-control popup-form" name="name" required /><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="email">E-mail:</label>
                                            <input id="email" class="form-control popup-form" name="email" rows="8" required><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="text">Tekst:</label>
                                            <textarea type="text" id="text" class="form-control popup-form" name="text" required></textarea><br /><br />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-secondary" for="img_url">Afbeeldings-URL:</label>
                                            <input type="text" id="img_url" class="form-control popup-form" name="img_url" required /><br /><br />
                                        </div>
                                        <div class="btn-message pt-3">
                                            <button class="pt-2 btn btn-secondary btn-lg" type="submit" name="submit">Team
                                                aanpassen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="aanvraag-goedkeuren.php" class="pt-2 btn btn-primary btn-lg">Aanvragen overzicht</a>
                </div>
            </div>

            <!--Footer-->
            <div id="footer-placeholder"></div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        </body>

        </html>

        <?php
        exit();
    }
}

// Gebruiker is niet ingelogd als admin of niet ingelogd, doorverwijzen naar de login-pagina
header("Location: login.php");
exit();
?>