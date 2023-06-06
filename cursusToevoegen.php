<?php
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $enrollments = $_POST['enrollments'];
    $keywords = $_POST['keywords'];

    $host = 'localhost';
    $user = 'id19625723_root';
    $pass = 'ehboAvans23!';
    $dbname = 'id19625723_ehbo';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $sql = "INSERT INTO cursus (subject, date, enrollments, keywords) VALUES ('$subject', '$date', '$enrollments', '$keywords')";
    mysqli_query($conn, $sql);
}
?>