<?php
session_start();

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $postal = $_POST['postal'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $password = $_POST['password'];

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
        echo '<script>alert("reCAPTCHA verification failed. Please try again.");</script>';
    } else {



        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Controleer of het wachtwoord aan de vereisten voldoet met behulp van de regex
        $password_regex = '/^(?=.*\d)(?=.*[!@#$%^&*])\S{8,}/';
        if (!preg_match($password_regex, $password)) {
            echo "<h1>Registratie mislukt</h1>";
            echo "<p>Ongeldig wachtwoord. Zorg ervoor dat je wachtwoord minimaal 8 tekens bevat, minimaal 1 cijfer en 1 speciaal teken.</p>";
            return;
        }

        $postcode_regex = '/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/';
        if (preg_match($postcode_regex, $postal)) {
            // echo "De postcode voldoet aan de eisen.";
        } else {
            echo "De postcode voldoet niet aan de eisen.";
        }

        $host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
        $user = 'Knv-ehbo-tilburg';
        $pass = '3HBO!';
        $dbname = 'Knv-ehbo-tilburg';
        $port = 25060;

        $conn = mysqli_init();
        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_real_connect($conn, $host, $user, $pass, $dbname, $port);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO user (firstname, lastname, email, postal, city, address, description, password) 
            VALUES ('$firstname', '$lastname', '$email', '$postal', '$city', '$address', '$description', '$password_hash')";

        if ($conn->query($sql) === TRUE) {
            //echo '<script>alert("Uw nieuwe account is aangevraagd!");</script>';
            header("Location: aanvragen-bericht.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }
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
        <!--Account aanvragen-->
        <div class="jumbotron bg-inloggen">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Account aanvragen</p>
            </div>
            <div class="container pt-5 pb-5">
                <form id="contact-form" class="login-form" action="account-aanvragen.php" method="POST" role="form">
                    <div class="form-group">
                        <label class="form-label text-main" for="firstname">Voornaam</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="lastname">Achternaam</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="postal">Postcode</label>
                        <input
                            type="text"
                            class="form-control"
                            id="postal"
                            name="postal"
                            placeholder="(Bijv. 1234 AB)"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="city">Stad</label>
                        <input type="text" class="form-control" id="city" name="city" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="address">Adres</label>
                        <input type="text" class="form-control" id="address" name="address" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="description">Reden voor aanvraag</label>
                        <textarea
                            class="form-control"
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Waarom wilt u een account aanvragen?"
                            required
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="password">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>

                    <div class="g-recaptcha py-2" data-sitekey="6Lfe7Y0mAAAAAPYK1bkiGOTGVLo4VVwS8s4cICA_
                        "></div>
                    <div class="btn-message pt-3">
                        <button class="btn btn-primary btn-lg" type="submit" name="submit">Stuur aanvraag</button>
                    </div>
                </form>
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
