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
    $query = "SELECT * FROM course WHERE date >= CURDATE() ORDER BY date ASC";
    $result = mysqli_query($conn, $query);

    // Generate HTML for courses
    $coursesHTML = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = date('d-m-Y', strtotime($row["date"]));
            $subject = $row["subject"];
            $keywords = $row["keywords"];
            $max_enrollments = $row["max_enrollments"];
            $enrollments = $row["enrollments"];
            $enrollments_text = $enrollments . "/" . $max_enrollments;

            $courseHTML = '
            <div class="row">
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <p class="card-text">' . $date . '</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="card-text">' . $subject . '</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="card-text">' . $keywords . '</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="card-text">' . $enrollments_text . '</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button class="btn btn-sm btn-primary">Inschrijven</button>
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

    <!--Navbar-->
    <div id="navbar-placeholder"></div>

    <!-- Ga terug button -->
    <div class="d-none d-lg-block">
        <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
    </div>

    <!-- Cursussen -->
    <div class="jumbotron bg-jumbotron">
        <div class="container">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Cursussen</p>
            </div>
            <div class="container">
                <div class="row">
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
