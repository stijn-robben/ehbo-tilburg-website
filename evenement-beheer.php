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

        $id_event = $_GET['id_event'];

        // Fetch event details from the database
        $eventQuery = "SELECT * FROM event WHERE id_event = $id_event";
        $eventResult = mysqli_query($conn, $eventQuery);

        // Check for errors in the query execution
        if (!$eventResult) {
            die("Error executing the query: " . mysqli_error($conn));
        }

        $eventName = '';
        $eventLocation = '';
        $eventDate = '';
        $eventStart_time = '';
        $eventEnd_time = '';

        $eventHTML = "";
        if ($eventResult->num_rows > 0) {
            $eventRow = mysqli_fetch_assoc($eventResult);
            $eventName = $eventRow["name"];
            $eventLocation = $eventRow["location"];
            $eventDate = date('d-m-Y', strtotime($eventRow["date"]));
            $eventStart_time = $eventRow["start_time"];
            $eventEnd_time = $eventRow["end_time"];

            $eventHTML = '
                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <p class="card-text">' . $eventName . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $eventDate . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $eventDate . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $eventStart_time . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $eventEnd_time . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        // Fetch enrollments from the database
        $query = "SELECT enrollment.id_enrollment, user.id_user, user.firstname, user.lastname, enrollment.present
                    FROM enrollment
                    JOIN user ON enrollment.id_user = user.id_user
                    WHERE enrollment.id_event = $id_event";

        $result = mysqli_query($conn, $query);

        // Check for errors in the query execution
        if (!$result) {
            die("Error executing the query: " . mysqli_error($conn));
        }

        // Generate HTML for enrollments
        $enrollmentsHTML = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_enrollment = $row["id_enrollment"];
                $id_user = $row["id_user"];
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $present = $row["present"];

                $isChecked = ($present == 1) ? 'checked' : '';

                $enrollmentHTML = '
                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <p class="card-text">' . $id_user . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $firstname . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . $lastname . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="card-text">' . ($present ? "Ja" : "Nee") . '</p>
                                    </div>
                                    <div class="col-md-2">
                                        <form method="POST" action="">
                                            <input type="hidden" name="id_enrollment" value="' . $id_enrollment . '">
                                            <input type="hidden" name="id_event" value="' . $id_event . '">
                                            <input type="checkbox" id="checkbox" name="present" value="1" ' . $isChecked . '>
                                            <input type="submit" name="save" value="Opslaan">
                                        </form>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <form action="" method="post" class="d-inline-block">
                                            <input type="hidden" name="id_enrollment" value="' . $id_enrollment . '">
                                            <input type="hidden" name="id_event" value="' . $id_event . '">
                                            <button type="submit" name="delete" class="btn btn-sm btn-primary">Verwijder</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';

                $enrollmentsHTML .= $enrollmentHTML;
            }
        }

        if (isset($_POST['delete'])) {
            $id_enrollment = $_POST['id_enrollment'];
            $id_event = $_POST['id_event'];

            // Remove enrollment from the database
            $deleteQuery = "DELETE FROM enrollment WHERE id_enrollment = $id_enrollment";
            if (mysqli_query($conn, $deleteQuery)) {
                header("Location: evenement-beheer.php?id_event=" . $id_event);
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }

        if (isset($_POST['save'])) {
            $id_enrollment = $_POST['id_enrollment'];
            $id_event = $_POST['id_event'];
            $present = (isset($_POST['present']) && $_POST['present'] == '1') ? 1 : 0;

            // Update the 'present' value in the enrollment table
            $updateQuery = "UPDATE enrollment SET present = $present WHERE id_enrollment = $id_enrollment";
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: evenement-beheer.php?id_event=" . $id_event);
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
            <link rel="stylesheet" href="./css/style.css" />
            <link rel="icon" type="image/x-icon" href="/img/s.png" />
            <script defer src="./js/script.js"></script>
            <title>EHBO Tilburg - Beheer Cursus</title>
        </head>

        <body class="bg-light">
            <!--Navbar-->
            <div id="navbar-placeholder"></div>

            <!-- Go back button -->
            <div class="d-none d-lg-block">
                <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
            </div>

            <div class="jumbotron bg-jumbotron">
                <div class="container">
                    <!-- Cursus -->
                    <div class="pb-5">
                        <div class="container">
                            <p class="jumbotron-head h2-secondary">Beheer Evenement
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5 class="text-main">Naam</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Datum</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Locatie</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Starttijd</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Eindtijd</h5>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo $eventHTML; ?>
                        </div>
                    </div>
                    
                    <!-- Inschrijvingen -->
                    <div class="pb-5">
                        <div class="container">
                            <p class="h2-secondary">Inschrijvingen</p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5 class="text-main">Lidnummer</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Voornaam</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Achternaam</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5 class="text-main">Goedgekeurd</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $enrollmentsHTML; ?>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div id="footer-placeholder"></div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
                crossorigin="anonymous"></script>
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
