<?php
    try{
        $dsn = "mysql: dbname=id19625723_ehbo; host=localhost";
        $user = "id19625723_root";
        $pswd = "ehboAvans23!";

        $conn = new PDO($dsn, $user, $pswd);

        $conn->query("USE id19625723_ehbo");
    }
    catch(PDOExeption $e){
        die("Error connecting: ".$e->getMessage());
    }
?>