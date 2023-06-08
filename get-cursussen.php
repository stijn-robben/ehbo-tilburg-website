<?php
session_start();

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

    // Fetch courses from the database
    $query = "SELECT * FROM cursus";
    $result = mysqli_query($conn, $query);

   // Generate HTML for courses
$coursesHTML = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = $row["date"];
        $subject = $row["subject"];
        $keywords = $row["keywords"];
        $enrollments = $row["enrollments"];

        $courseHTML = '
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="card-text">' . $date . '</p>
                            </div>
                            <div class="col-md-3">
                                <p class="card-text">' . $subject . '</p>
                            </div>
                            <div class="col-md-3">
                                <p class="card-text">' . $keywords . '</p>
                            </div>
                            <div class="col-md-3">
                                <p class="card-text">' . $enrollments . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button class="btn btn-sm btn-primary">Button</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $coursesHTML .= $courseHTML;
    }
}

// Close the database connection
$conn->close();
?>