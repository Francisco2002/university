<?php
    require_once "../db/connection.php";

    if(isset($_POST['subject_id']) && isset($_POST['teacher_cpf'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (subject_id, teacher_cpf) VALUES (:subject_id, :teacher_cpf);");

            $stmt->bindParam(":subject_id", $_POST['subject_id']);
            $stmt->bindParam(":teacher_cpf", $_POST['teacher_cpf']);

            $stmt->execute();
            
            header('Location: ../new_class.php?success');
        } catch (PDOException $e) {
            echo "Erro ao criar disciplina\n";
            echo "<strong>Erro: </strong>".$e.getMessage();
        }
    }
