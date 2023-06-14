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
$queryPart1 = "SELECT * FROM content WHERE page = 'activiteiten' AND part = 1";
$resultPart1 = mysqli_query($conn, $queryPart1);

$queryPart2 = "SELECT * FROM content WHERE page = 'activiteiten' AND part = 2";
$resultPart2 = mysqli_query($conn, $queryPart2);

$queryPart3 = "SELECT * FROM content WHERE page = 'activiteiten' AND part = 3";
$resultPart3 = mysqli_query($conn, $queryPart3);

// Generate HTML for content
$contentHTML = "";
if ($resultPart1->num_rows > 0) {
    while ($row = $resultPart1->fetch_assoc()) {
        $title = $row["title"];
        $text = $row["text"];
        $img_url = $row["img_url"];

        $contentHTML .= '<div class="jumbotron bg-jumbotron">
            <div class="container">
                <div class="d-lg-none">
                    <h1 class="jumbotron-head jumbotron-head-sm">
                        ' . $title . '
                    </h1>
                </div>
                <div class="d-none d-lg-block">
                    <h1 class="jumbotron-head">
                        ' . $title . '
                    </h1>
                </div>

                <p class="jumbotron-text col-md-7">
                    ' . $text . '
                </p>
            </div>
            <div class="col-md-6">
            <img src="' . $img_url . '" width="100%" class="rounded-3" alt="Foto van een EHBO training" />
        </div>
        </div>';
    }
}

if ($resultPart2->num_rows > 0) {
    while ($row = $resultPart2->fetch_assoc()) {
        $title = $row["title"];
        $text = $row["text"];
        $img_url = $row["img_url"];

        $contentHTML .= '<div class="container pb-5">
            <div class="pt-5">
                <p class="h2-main">' . $title . '</p>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-secondary">
                            ' . $text . '
                        </p>
                    </div>
                    <div class="col-md-6">
                        <img src="' . $img_url . '" width="100%" class="rounded-3" alt="Foto van een EHBO training" />
                    </div>
                </div>
            </div>
        </div>';
    }
}

if ($resultPart3->num_rows > 0) {
    while ($row = $resultPart3->fetch_assoc()) {
        $title = $row["title"];
        $text = $row["text"];
        $img_url = $row["img_url"];

        $contentHTML .= '<div class="bg-vereniging" id="vereniging">
            <div class="container pb-5">
                <div class="pt-5">
                    <p class="h2-secondary">' . $title . '</p>
                </div>
                <div>
                    <p class="text-main">
                        ' . $text . '
                    </p>
                </div>
                <div class="col-md-6">
                <img src="' . $img_url . '" width="100%" class="rounded-3" alt="Foto van een EHBO training" />
            </div>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="icon" type="image/x-icon" href="/img/s.png" />
    <script defer src="./js/script.js"></script>
    <title>EHBO Tilburg - Homepage</title>
</head>

<body class="bg-light">


    <!--Navbar-->
    <div id="navbar-placeholder"></div>

    <!-- Ga terug button -->
    <div class="d-none d-lg-block">
        <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
    </div>

    <!-- Cursussen -->
    <?php echo $contentHTML; ?>

    <!--Footer-->
    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>