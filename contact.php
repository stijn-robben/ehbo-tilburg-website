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
