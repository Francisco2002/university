<?php
    require_once "../db/connection.php";

    if (isset($_POST['name']) && isset($_POST['acronym']) && isset($_POST['institute_id'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO subjects (id, name, offering_institute) VALUES (:acronym, :name, :institute)");
            
            $stmt->bindParam(":name", $_POST['name']);
            $stmt->bindParam(":acronym", $_POST['acronym']);
            $stmt->bindParam(":institute", $_POST['institute_id']);

            $stmt->execute();

            header('Location: ../new_subject.php?success');
        } catch(PDOException $e) {
            echo "Erro ao criar disciplina\n";
            echo "<strong>Erro: </strong>".$e.getMessage();
        }
    }
