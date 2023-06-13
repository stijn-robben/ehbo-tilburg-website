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
        $approved = $row['approved'];
        $role = $row['role'];

        $_SESSION['id_user'] = $id_user;

        // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord
        if (password_verify($password, $hashed_password)) {
            if ($approved == 1) {
                $_SESSION['loggedin'] = true;
                if ($role == 'admin') {
                    header("Location: beheer.php");
                    exit(); // Zorg ervoor dat de verdere code niet wordt uitgevoerd na de doorverwijzing
                } else {
                    header("Location: index.html");
                    exit();
                }
            }else{
                echo "Je account is niet goed gekeurd.";
            }
            
            // Voer hier de verdere logica uit nadat de gebruiker succesvol is ingelogd
        } else {
            echo "Ongeldig ID of wachtwoord.";
        }
    } else {
        echo "Ongeldig ID of wachtwoord.";
    }

    $_SESSION['loggedin'] = true;
    mysqli_close($conn);
}
?>