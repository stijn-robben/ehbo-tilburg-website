<?php
session_start();

if (isset($_GET['id_course'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin'])) {
        // User is not logged in, redirect to the login page
        header("Location: login.php");
        exit();
    }

    // Get the values from GET data
    $id_course = $_GET['id_course'];
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

    // Lock the course row to prevent concurrent enrollment
    $lockQuery = "SELECT * FROM course WHERE id_course = '$id_course' FOR UPDATE";
    $lockResult = mysqli_query($conn, $lockQuery);

    if (!$lockResult) {
        echo "Query error: " . mysqli_error($conn);
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
            // Commit the transaction
            mysqli_commit($conn);
            header("Location: cursussen.php");
            exit();
        } else {
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Enrollment does not exist
        // Check the current enrollments count
        $enrollmentsCountQuery = "SELECT COUNT(*) AS enrollments_count FROM enrollment WHERE id_course = '$id_course'";
        $enrollmentsCountResult = mysqli_query($conn, $enrollmentsCountQuery);

        if (!$enrollmentsCountResult) {
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Query error: " . mysqli_error($conn);
            exit();
        }

        $row = mysqli_fetch_assoc($enrollmentsCountResult);
        $enrollmentsCount = $row['enrollments_count'];

        // Fetch the maximum enrollments limit for the course
        $maxEnrollmentsQuery = "SELECT max_enrollments FROM course WHERE id_course = '$id_course'";
        $maxEnrollmentsResult = mysqli_query($conn, $maxEnrollmentsQuery);

        if (!$maxEnrollmentsResult) {
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Query error: " . mysqli_error($conn);
            exit();
        }

        $row = mysqli_fetch_assoc($maxEnrollmentsResult);
        $maxEnrollments = $row['max_enrollments'];

        if ($enrollmentsCount < $maxEnrollments) {
            // There is still room for enrollment
            // Insert the enrollment record
            $insertQuery = "INSERT INTO enrollment (id_course, id_user) VALUES ('$id_course', '$id_user')";
            if (mysqli_query($conn, $insertQuery)) {
                // Commit the transaction
                mysqli_commit($conn);
                header("Location: cursussen.php");
                exit();
            } else {
                // Rollback the transaction
                mysqli_rollback($conn);
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // The maximum enrollments limit has been reached
            // Rollback the transaction
            mysqli_rollback($conn);
            echo "Maximum enrollments limit reached for this course.";
        }
    }

    // Release the lock and close the connection
    mysqli_query($conn, 'UNLOCK TABLES');
    mysqli_close($conn);
}
?>
