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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
            <link rel="stylesheet" href="./css/style.css" />
            <link rel="icon" type="image/x-icon" href="/img/s.png" />
            <script defer src="./js/script.js"></script>
            <title>EHBO Tilburg - Aanvraag goedkeuren</title>
        </head>

        <body class="bg-light">
            <?php
            // session_start();
    
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
            $query = "SELECT * FROM user WHERE approved = 0";
            $result = mysqli_query($conn, $query);

            // Generate HTML for courses
            $coursesHTML = "";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id_user'];
                    $voornaam = $row['firstname'];
                    $achternaam = $row['lastname'];
                    $approved = $row['approved'];
                    $description = $row['description'];

                    $courseHTML = '
                    <div class="row">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p class="card-text">' . $id . '</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="card-text">' . $voornaam . '</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="card-text">' . $achternaam . '</p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="card-text">' . $description . '</p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <form action="" method="post" class="d-inline-block">
                                                <input type="hidden" name="id" value="' . $id . '">
                                                <button type="submit" name="approve" class="btn btn-sm btn-primary">ㅤㅤ✓ㅤㅤ</button>
                                            </form>
                                            <form action="" method="post" class="d-inline-block">
                                                <input type="hidden" name="id" value="' . $id . '">
                                                <button type="submit" name="delete" class="btn btn-sm btn-primary">ㅤㅤXㅤㅤ</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

                    $coursesHTML .= $courseHTML;
                }
            }
            // Approve button action
            if (isset($_POST['approve'])) {
                $id = $_POST['id'];
                $updateQuery = "UPDATE user SET approved = 1 WHERE id_user = $id";
                mysqli_query($conn, $updateQuery);
                // Redirect to the same page to refresh the content
                // header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Delete button action
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $deleteQuery = "DELETE FROM user WHERE id_user = $id";
                mysqli_query($conn, $deleteQuery);
                // Redirect to the same page to refresh the content
                // header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Close the database connection
            $conn->close();
            ?>


            <!--Navbar-->
            <div id="navbar-placeholder"></div>

            <!-- Ga terug button -->
            <div class="d-none d-lg-block">
                <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
            </div>

            <!-- approved -->
            <div class="jumbotron bg-jumbotron">
                <div class="container">
                    <div class="container">
                        <p class="jumbotron-head h2-secondary">Aanvragen</p>
                    </div>
                    <div class="container">
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
                                            <div class="col-md-3">
                                                <h5 class="text-main">Reden Aanvraag</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $coursesHTML; ?>
                    </div>
                </div>
            </div>

            <!--Footer-->
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