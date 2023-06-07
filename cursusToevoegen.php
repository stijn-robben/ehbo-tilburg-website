<?php
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $enrollments = $_POST['enrollments'];
    $keywords = $_POST['keywords'];

    $conn = mysqli_connect($host, $user, $pass, $dbname);

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

    $sql = "INSERT INTO cursus (subject, date, enrollments, keywords) VALUES ('$subject', '$date', '$enrollments', '$keywords')";
   
    if (mysqli_query($conn, $sql)) {
        echo "Cursus toegevoegd.";
    } else {
        echo "Fout bij het toevoegen van een cursus." . mysqli_error($conn);
    }

    mysqli_close($conn);

}
?>