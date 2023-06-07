<?php
session_start();

    try{
        $dsn = "mysql: dbname=Knv-ehbo-tilburg; host=Knv-ehbo-tilburg";
        $user = "Knv-ehbo-tilburg";
        $pswd = "3HBO!";

        $conn = new PDO($dsn, $user, $pswd);

        $conn->query("USE Knv-ehbo-tilburg");
    }
    catch(PDOExeption $e){
        die("Error connecting: ".$e->getMessage());
    }
?>