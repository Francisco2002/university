<?php
    require_once "../db/connection.php";

    if(isset($_POST['institute_id'])) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM teachers WHERE institute_id = :institute_id");

            $stmt->bindParam(":institute_id", $_POST['institute_id']);

            $stmt->execute();

            $teachers = array();

            if($stmt->rowCount() > 0) {
                while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $teachers[] = array(
                        'cpf' => $teacher['cpf'],
                        'name' => $teacher['name']
                    );
                }
            }

            echo json_encode($teachers);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    }