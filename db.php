<?php
$user = "root";
$pass = "";
    try {
        $connection = new PDO('mysql:host=site.local;dbname=adsite', $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
