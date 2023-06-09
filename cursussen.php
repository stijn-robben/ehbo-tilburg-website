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

// Fetch courses from the database along with the enrollment count
// Fetch courses from the database along with the enrollment count
$query = "SELECT c.*, COUNT(e.id_enrollment) AS enrollments_count, 
          COUNT(en.id_enrollment) AS user_enrollments_count
          FROM course AS c 
          LEFT JOIN enrollment AS e ON c.id_course = e.id_course 
          LEFT JOIN enrollment AS en ON c.id_course = en.id_course AND en.id_user = $id_user
          WHERE c.date >= CURDATE() 
          GROUP BY c.id_course 
          ORDER BY c.date ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit();
}

// Generate HTML for courses
$coursesHTML = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_course = $row["id_course"];
        $date = date('d-m-Y', strtotime($row["date"]));
        $subject = $row["subject"];
        $keywords = $row["keywords"];
        $max_enrollments = $row["max_enrollments"];
        
        // Fetch the enrollment count for the current user and course
        $enrollments_query = "SELECT COUNT(*) AS user_enrollments_count
                              FROM enrollment 
                              WHERE id_course = $id_course AND id_user = $id_user";
        $enrollments_result = mysqli_query($conn, $enrollments_query);

        if (!$enrollments_result) {
            echo "Query error: " . mysqli_error($conn);
            exit();
        }
        
        $enrollments_count = $row["enrollments_count"];
        $enrollments_text = $enrollments_count . "/" . $max_enrollments;

        if ($_SESSION['role'] == 'admin') {
            // User is admin, show "Beheer" link
            $linkLabel = "Beheer";
            $linkAction = "cursus-beheer.php?id_course=" . $id_course;
        } else {
            if ($row["user_enrollments_count"]) {
                // User is already enrolled in the course, show "Uitschrijven" link
                $linkLabel = "Uitschrijven";
            } else {
                // User is not enrolled in the course
                if ($enrollments_count < $max_enrollments) {
                    // Maximum enrollments limit not reached, show "Inschrijven" link
                    $linkLabel = "Inschrijven";
                } else {
                    // Maximum enrollments limit reached, show disabled link
                    $linkLabel = "Maximum bereikt";
                }
            }
            $linkAction = "cursus-inschrijven-uitschrijven.php?id_course=" . $id_course;
        }      

        $courseHTML = '
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Datum: </span><span class="card-text">' . $date . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Onderwerp: </span><span class="card-text">' . $subject . '</span>
                            </div>
                            <div class="col-md-3">
                                <span class="card-text d-lg-none">Competenties: </span><span class="card-text">' . $keywords . '</span>
                            </div>
                            <div class="col-md-2">
                                <span class="card-text d-lg-none">Aantal inschrijvingen: </span><span class="card-text">' . $enrollments_text . '</span>
                            </div>
                            <div class="col-md-3 pt-2">
                                <a href="' . $linkAction . '" class="btn btn-sm btn-primary' . ($linkLabel === "Maximum bereikt" ? " disabled" : "") . '">' . $linkLabel . '</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $coursesHTML .= $courseHTML;
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
    <title>EHBO Tilburg - Cursussen</title>
</head>

<body class="bg-light">
    <!--Navbar-->
    <div id="navbar-placeholder"></div>

    <!-- Ga terug button -->
    <div class="d-none d-lg-block">
        <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
    </div>

    <!-- Cursussen -->
    <div class="jumbotron bg-jumbotron pb-5">
        <div class="container">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Cursussen</p>
            </div>
            <div class="container">
                <div class="row d-none d-lg-block">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h5 class="text-main">Datum</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-main">Onderwerp</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-main">Competenties</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-main">Aantal inschrijvingen</h5>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
