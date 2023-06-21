<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // User is not logged in, redirect to the login page
    header("Location: inloggen.php");
    exit();
}

// Assign the value of id_user from the session to a variable
$id_user = $_SESSION['id_user'];

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

// Fetch events from the database along with the enrollment count
$query = "SELECT e.*, COUNT(en.id_enrollment) AS enrollments_count, 
          COUNT(en.id_enrollment) AS user_enrollments_count
          FROM event AS e 
          LEFT JOIN enrollment AS en ON e.id_event = en.id_event AND en.id_user = $id_user
          WHERE e.date >= CURDATE() 
          GROUP BY e.id_event 
          ORDER BY e.date ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit();
}

// Generate HTML for events
$eventsHTML = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_event = $row["id_event"];
        $name = $row["name"];
        $location = $row["location"];
        $date = date('d-m-Y', strtotime($row["date"]));
        $start_time = $row["start_time"];
        $end_time = $row["end_time"];
        
        // Fetch the enrollment count for the current user and event
        $enrollments_query = "SELECT COUNT(*) AS user_enrollments_count
                              FROM enrollment 
                              WHERE id_event = $id_event AND id_user = $id_user";
        $enrollments_result = mysqli_query($conn, $enrollments_query);

        if (!$enrollments_result) {
            echo "Query error: " . mysqli_error($conn);
            exit();
        }

        if ($_SESSION['role'] == 'admin') {
            // User is admin, show "Beheer" link
            $linkLabel = "Beheer";
            $linkAction = "evenement-beheer.php?id_event=" . $id_event;
        } else {
            if ($row["user_enrollments_count"]) {
                // User is already enrolled in the event, show "Uitschrijven" link
                $linkLabel = "Uitschrijven";
            } else {
                // User is not enrolled in the event
                $linkLabel = "Inschrijven";
            }
            $linkAction = "evenement-inschrijven-uitschrijven.php?id_event=" . $id_event;
        }      

        $eventHTML = '
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Naam: </span><span class="card-text">' . $name . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Datum: </span><span class="card-text">' . $date . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Locatie: </span><span class="card-text">' . $location . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Starttijd: </span><span class="card-text">' . $start_time . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Eindtijd: </span><span class="card-text">' . $end_time . '</span>
                            </div>
                            <div class="col-md-2 pt-2">
                                <a href="' . $linkAction . '" class="btn btn-sm btn-primary' . ($linkLabel === "Maximum bereikt" ? " disabled" : "") . '">' . $linkLabel . '</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $eventsHTML .= $eventHTML;
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
    <title>EHBO Tilburg - Evenementen</title>
</head>

<body class="bg-light">
    <!--Navbar-->
    <div id="navbar-placeholder"></div>

    <!-- Ga terug button -->
    <div class="d-none d-lg-block">
        <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
    </div>

    <!-- Evenementen -->
    <div class="jumbotron bg-jumbotron pb-5">
        <div class="container">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Evenementen</p>
            </div>
            <div class="container">
                <div class="row d-none d-lg-block">
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
                <?php echo $eventsHTML; ?>
            </div>
        </div>
    </div>

    <!--Footer-->
    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
