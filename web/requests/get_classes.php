<?php
    require_once "../db/connection.php";

    if(isset($_POST['subject_id'])) {
        try {
            $stmt = $pdo->prepare("SELECT subjects.name as subject_name, teachers.name as teacher_name FROM classes INNER JOIN subjects ON classes.subject_id = subjects.id INNER JOIN teachers ON classes.teacher_cpf = teachers.cpf WHERE classes.subject_id = :subject_id");

            $stmt->bindParam(":subject_id", $_POST['subject_id']);

            $stmt->execute();

            $classes = array();

            if($stmt->rowCount() > 0) {
                while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $classes[] = array(
                        'subject_name' => $class['subject_name'],
                        'teacher_name' => $class['teacher_name']
                    );
                }
            }

            echo json_encode($classes);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    }