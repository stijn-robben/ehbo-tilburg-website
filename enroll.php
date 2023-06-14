<?php
session_start();

if (isset($_POST['submit'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin'])) {
        // User is not logged in, redirect to the login page
        header("Location: inloggen.html");
        exit();
    }

    // Get the values from POST data
    $id_course = $_POST['id_course'];
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

    // Check if the enrollment already exists
    $existingEnrollmentQuery = "SELECT * FROM enrollment WHERE id_course = '$id_course' AND id_user = '$id_user'";
    $existingEnrollmentResult = mysqli_query($conn, $existingEnrollmentQuery);

    if (!$existingEnrollmentResult) {
        echo "Query error: " . mysqli_error($conn);
        exit();
    }

    if ($existingEnrollmentResult->num_rows > 0) {
        // Enrollment already exists
        // Unsubscribe the user from the course
        $query = "DELETE FROM enrollment WHERE id_course = '$id_course' AND id_user = '$id_user'";
        if (mysqli_query($conn, $query)) {
            header("Location: cursussen.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Enrollment does not exist
        // Enroll the user in the course
        $query = "INSERT INTO enrollment (id_course, id_user) VALUES ('$id_course', '$id_user')";
        if (mysqli_query($conn, $query)) {
            header("Location: cursussen.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where id_course and/or id_enrollment are not set in the POST data
    // For example, redirect the user to an error page or display an error message
    $errorMessage = "Invalid request. Please try again.";
    echo $errorMessage;
}
?>
