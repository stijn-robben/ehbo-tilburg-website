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
    $query = "SELECT * FROM content WHERE page = 'homepage'";
    $result = mysqli_query($conn, $query);

    // Generate HTML for content
    $contentHTML = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $title = $row["title"];
            $text = $row["text"];
            $img_url = $row["img_url"];

            $contentHTML .= '        <div class="jumbotron bg-jumbotron">
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
        </div>';
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
        <div class="d-none d-lg-block">
            <?php echo $contentHTML; ?>
        </div>
    </div>

    <!--Footer-->
    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>