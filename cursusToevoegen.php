<?php
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $enrollments = $_POST['enrollments'];
    $keywords = $_POST['keywords'];

    $host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
    $user = 'Knv-ehbo-tilburg';
    $pass = 'Ehbo123!';
    $dbname = 'Knv-ehbo-tilburg';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $sql = "INSERT INTO cursus (subject, date, enrollments, keywords) VALUES ('$subject', '$date', '$enrollments', '$keywords')";
    mysqli_query($conn, $sql);
}
?>