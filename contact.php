<?php
session_start();

// Gegevens voor de databaseverbinding
$host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
$port = 25060;
$user = 'Knv-ehbo-tilburg';
$pass = '3HBO!';
$dbname = 'Knv-ehbo-tilburg';

// Verbinding maken met de database
$conn = new mysqli($host, $user, $pass, $dbname, $port);

$recaptcha_secret = '6Lfe7Y0mAAAAAALHCbs8FHqgfsHoFUKuT0Mc8EEF
';
$response = $_POST['g-recaptcha-response'];

// Make a POST request to verify the reCAPTCHA response
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'secret' => $recaptcha_secret,
    'response' => $response
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$recaptcha_result = curl_exec($ch);
curl_close($ch);

$recaptcha_result = json_decode($recaptcha_result);

if (!$recaptcha_result->success) {
    // The reCAPTCHA verification failed
    echo '<script>alert("reCAPTCHA verification failed. Please try again.");</script>';
} else {
    // Controleren op fouten bij de verbinding
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Controleren of het formulier is verzonden
    if (isset($_POST["submit"])) {
        // Gegevens uit het formulier halen
        $name = $_POST["name"];
        $email = $_POST["email"];
        $telefoon = $_POST["telefoon"];
        $description = $_POST["description"];

        // Query om de gegevens in de database in te voegen
        $sql = "INSERT INTO contact (name, email, phonenumber, message) VALUES ('$name', '$email', '$telefoon', '$description')";

        // Controleren of de query succesvol is uitgevoerd
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Bedankt voor je bericht!");</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Verbinding met de database sluiten
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Website van KNV EHBO Tilburg." />
        <meta name="robots" content="index, follow" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="icon" type="image/x-icon" href="/img/s.png" />
        <script defer src="./js/script.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <title>EHBO Tilburg</title>
    </head>

    <body class="bg-light">
        <!--Navbar-->
        <div id="navbar-placeholder"></div>

        <!-- Ga terug button -->
        <div class="d-none d-lg-block">
            <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
        </div>
        <!--Contact formulier-->
        <div class="jumbotron bg-inloggen">
            <div class="jumbotron bg-inloggen">
                <div class="container">
                    <p class="jumbotron-head h2-secondary">Contact</p>
                </div>
                <div class="container pt-5">
                    <form id="contact-form" class="login-form" action="contact.php" method="POST" role="form">
                        <div class="form-group">
                            <label class="form-label text-main pt-3" for="name">Naam</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label text-main pt-3" for="email">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label text-main pt-3" for="telefoon">Telefoon</label>
                            <input
                                type="text"
                                class="form-control"
                                id="telefoon"
                                name="telefoon"
                                placeholder=""
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label text-main pt-3" for="description">Opmerking</label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="3"
                                placeholder=""
                                required
                            ></textarea>
                        </div>
                        <div class="g-recaptcha py-2" data-sitekey="6Lfe7Y0mAAAAAPYK1bkiGOTGVLo4VVwS8s4cICA_
                        "></div>
                        <div class="btn-message pt-3">
                            <button class="pt-2 btn btn-primary btn-lg" type="submit" name="submit">Versturen</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>

        <!--Footer-->
        <div id="footer-placeholder"></div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
        ></script>
    </body>
</html>