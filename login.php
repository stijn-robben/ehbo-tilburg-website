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

    //     $mypass = "1234";
//     $myhashpass = password_hash($mypass, PASSWORD_DEFAULT);
//     if (password_verify($mypass, $myhashpass)) {
//      echo "Password is correct"';
// } else {
//     // Password is incorrect
// }

    $conn = mysqli_init();
    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    mysqli_real_connect($conn, $host, $user, $pass, $dbname, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Haal het gehashte wachtwoord op uit de database op basis van het ingevoerde ID

    // $sql = "SELECT password FROM user WHERE id_user = $id";
    // $result = mysqli_query($conn, $sql);

    // if ($result && mysqli_num_rows($result) > 0) {
    //     $row = mysqli_fetch_assoc($result);
    //     $hashed_password = $row['password'];

    $query = "SELECT * FROM user WHERE id_user = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Gebruiker gevonden, toon gegevens op nieuwe pagina
        // $row = $result->fetch_assoc();
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $voornaam = $row['firstname'];
        $achternaam = $row['lastname'];
        $email = $row['email'];
        $postcode = $row['postal'];
        $woonplaats = $row['city'];
        $adres = $row['address'];
        $beschrijving = $row['description'];
        $approved = $row['approved'];
        $role = $row['role'];
        $_SESSION['approved'] = $approved;
        $_SESSION['role'] = $role;

        // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord
        if (password_verify($password, $hashed_password)) {
            //echo "Inloggen gelukt!";
            if ($approved == 1) {
               // echo "approved is 1";
                $_SESSION['loggedin'] = true;
                if ($role == 'admin') {
                  //  echo "role is admin";
                    // Nieuwe pagina voor admin weergeven
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