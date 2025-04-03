<?php
    require_once "../db/connection.php";

    if(isset($_POST['institute_id'])) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM subjects WHERE offering_institute = :institute_id");

            $stmt->bindParam(":institute_id", $_POST['institute_id']);

            $stmt->execute();

            $subjects = array();

            if($stmt->rowCount() > 0) {
                while ($subject = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $subjects[] = array(
                        'id' => $subject['id'],
                        'name' => $subject['name']
                    );
                }
            }

            echo json_encode($subjects);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    }