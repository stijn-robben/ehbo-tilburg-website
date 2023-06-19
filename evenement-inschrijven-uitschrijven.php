<?php
session_start();

if (isset($_GET['id_event'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin'])) {
        // User is not logged in, redirect to the login page
        header("Location: login.php");
        exit();
    }

    // Get the values from GET data
    $id_event = $_GET['id_event'];
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

    // Begin a transaction
    mysqli_autocommit($conn, false);

    // Lock the event row to prevent concurrent enrollment
    $lockQuery = "SELECT * FROM event WHERE id_event = '$id_event' FOR UPDATE";
    $lockResult = mysqli_query($conn, $lockQuery);

    if (!$lockResult) {
        echo "Query error: " . mysqli_error($conn);
        exit();
    }

    // Check if the enrollment already exists
    $existingEnrollmentQuery = "SELECT * FROM enrollment WHERE id_event = '$id_event' AND id_user = '$id_user'";
    $existingEnrollmentResult = mysqli_query($conn, $existingEnrollmentQuery);

    if (!$existingEnrollmentResult) {
        echo "Query error: " . mysqli_error($conn);
        exit();
    }

    if ($existingEnrollmentResult->num_rows > 0) {
        // Enrollment already exists
        // Unsubscribe the user from the event
        $query = "DELETE FROM enrollment WHERE id_event = '$id_event' AND id_user = '$id_user'";
        if (mysqli_query($conn, $query)) {
            // Commit the transaction
            mysqli_commit($conn);
            header("Location: evenementen.php");
            exit();
        } else {
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Enrollment does not exist
        // Insert the enrollment record
        $insertQuery = "INSERT INTO enrollment (id_event, id_user) VALUES ('$id_event', '$id_user')";
        if (mysqli_query($conn, $insertQuery)) {
            // Commit the transaction
            mysqli_commit($conn);
            header("Location: evenementen.php");
            exit();
        } else {
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Release the lock and close the connection
    mysqli_query($conn, 'UNLOCK TABLES');
    mysqli_close($conn);
}
?>
