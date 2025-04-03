<?php
    $host = "database";
    $dbname = getenv('POSTGRES_DB');
    $db_user = getenv('POSTGRES_USER');
    $db_password = getenv('POSTGRES_PASSWORD');

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $db_user, $db_password);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database connection error!!";
        exit();
    }