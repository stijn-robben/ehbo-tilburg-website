<?php
session_start();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];

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

    $query = "SELECT * FROM user WHERE id_user = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $id_user = $row['id_user'];
        $voornaam = $row['firstname'];
        $achternaam = $row['lastname'];
        $email = $row['email'];
        $postcode = $row['postal'];
        $woonplaats = $row['city'];
        $adres = $row['address'];
        $beschrijving = $row['description'];
        $approved = $row['approved'];
        $role = $row['role'];

        $_SESSION['id_user'] = $id_user;
        $_SESSION['role'] = $role;

        // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord
        if (password_verify($password, $hashed_password)) {
            if ($approved == 1) {
                if ($role == 'admin') {
                    $_SESSION['loggedin'] = true;
                    header("Location: index.php");
                    exit();
                } else {
                    $_SESSION['loggedin'] = true;
                    header("Location: index.php");
                    exit();
                }
            } else{
                echo "Je account is niet goed gekeurd.";
            }
            
            // Voer hier de verdere logica uit nadat de gebruiker succesvol is ingelogd
        } else {
            echo "Ongeldig ID of wachtwoord.";
        }
    } else {
        $_SESSION['loggedin'] = false;
    }

    mysqli_close($conn);
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
        <title>EHBO Tilburg</title>
    </head>

    <body class="bg-light">
        <!--Navbar-->
        <div id="navbar-placeholder"></div>

        <!-- Ga terug button -->
        <div class="d-none d-lg-block">
            <a class="btn btn-secondary btn-lg go-back" onclick="goBack()" role="button"> Ga terug </a>
        </div>
        <!-- Inloggen -->
        <div class="jumbotron bg-inloggen">
            <div class="container">
                <p class="jumbotron-head h2-secondary">Inloggen</p>
            </div>
            <div class="container pt-5">
                <form id="contact-form" class="login-form" action="inloggen.php" method="POST" role="form">
                    <div class="form-group">
                        <label class="form-label text-main" for="id">Lidnummer</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label text-main pt-3" for="password">Wachtwoord</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder=""
                            required
                        />
                    </div>
                    <div class="btn-message pt-3">
                        <button class="pt-2 btn btn-primary btn-lg" type="submit" name="submit">Inloggen</button>
                        <a href="account-aanvragen.php" class="pt-2 btn btn-primary btn-lg">Account aanvragen</a>
                        <br /><br />
                        <a
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#forgotPasswordModal"
                            class="forgot-password"
                        >
                            <p class="text-main">Wachtwoord vergeten?</p>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!--Wachtwoord vergeten pop-up-->
        <div
            class="modal fade"
            id="forgotPasswordModal"
            tabindex="-1"
            aria-labelledby="forgotPasswordModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-secondary" id="forgotPasswordModalLabel">Wachtwoord vergeten</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="email" class="text-secondary form-label">Email</label>
                                <input type="email" class="form-control" id="email" required />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-secondary">Verstuur</button>
                    </div>
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
