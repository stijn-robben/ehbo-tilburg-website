<?php
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

$id_course = $_GET['id_course'];

// Fetch course details from the database
$courseQuery = "SELECT * FROM course WHERE id_course = $id_course";
$courseResult = mysqli_query($conn, $courseQuery);

$courseDate = '';
$courseSubject = '';
$courseKeywords = '';

$courseHTML = "";
if ($courseResult->num_rows > 0) {
    $courseRow = mysqli_fetch_assoc($courseResult);
    $courseDate = $courseRow['date'];
    $courseSubject = $courseRow['subject'];
    $courseKeywords = $courseRow['keywords'];

    $courseHTML = '
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="card-text">' . $courseDate . '</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text">' . $courseSubject . '</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text">' . $courseKeywords. '</p>
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
            WHERE enrollment.id_course = $id_course";

$result = mysqli_query($conn, $query);

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
                                    <input type="checkbox" id="checkbox" name="present" value="1" ' . $isChecked . '>
                                    <input type="submit" name="save" value="Opslaan">
                                </form>
                            </div>
                            <div class="col-md-2 text-center">
                                <form action="" method="post" class="d-inline-block">
                                    <input type="hidden" name="id_enrollment" value="' . $id_enrollment . '">
                                    <button type="submit" name="verwijder" class="btn btn-sm btn-primary">Verwijder</button>
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

if (isset($_POST['verwijder'])) {
    $id = $_POST['id_enrollment'];

    // Remove enrollment from the database
    $deleteQuery = "DELETE FROM enrollment WHERE id_enrollment = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: inschrijvingen-beheer.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['save'])) {
    $id = $_POST['id_enrollment'];
    $present = (isset($_POST['present']) && $_POST['present'] == '1') ? 1 : 0;

    // Update the 'present' value in the enrollment table
    $updateQuery = "UPDATE enrollment SET present = $present WHERE id_enrollment = $id";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: inschrijvingen-beheer.php");
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
                    <p class="jumbotron-head h2-secondary">Beheer Cursus</p>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5 class="text-main">Datum</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="text-main">Onderwerp</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="text-main">Competenties</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $courseHTML; ?>
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
                                        <h5 class="text-main">Aanwezig</h5>
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
