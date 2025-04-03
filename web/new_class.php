<?php
    require_once "db/connection.php";

    try {
        $stmt = $pdo->prepare("SELECT * FROM institutes");
        $stmt->execute();

        $institutes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao listar institutos\n";
        echo "<strong>Erro: </strong>".$e.getMessage();
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova turma</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div>
        <h1>Nova turma</h1>

        <?php
            if(isset($_GET['success'])) {
                echo "<p>Turma criada com sucesso!!</p>";
            }
        ?>

        <form method="POST" action="actions/create_class.php">
            <select name="institute_id" id="institute" required>
                <option value="" disabled selected>Instituto...</option>
                <?php
                    foreach ($institutes as $institute)
                        echo "<option value='".$institute['id']."'>".$institute['name']."</option>";
                ?>
            </select>

            <select name="subject_id" id="subject" required></select>
            <select name="teacher_cpf" id="teacher" required></select>

            <button type="submit">Salvar</button>
        </form>

        <ul id="classes-list"></ul>
    </div>

    <script>
        // Usando jQuery para enviar a requisição AJAX
        $('#institute').change(function() {
            var instituteId = $(this).val();

            // Se uma categoria for selecionada
            if (instituteId) {
                $.ajax({
                    url: 'requests/get_subjects.php',
                    type: 'POST',
                    data: { institute_id: instituteId },
                    dataType: 'json',
                    success: function(data) {
                        // Limpa o segundo select antes de adicionar as novas opções
                        $('#subject').html('<option value="" disabled selected>Disciplina...</option>');

                        if (data.length > 0) {
                           // Adiciona as opções ao select
                            $.each(data, function(index, subject) {
                                $('#subject').append('<option value="' + subject.id + '">' + subject.name + '</option>');
                        });
                    }
                    }
                });

                $.ajax({
                    url: 'requests/get_teachers.php',
                    type: 'POST',
                    data: { institute_id: instituteId },
                    dataType: 'json',
                    success: function(data) {
                        // Limpa o segundo select antes de adicionar as novas opções
                        $('#teacher').html('<option value="" disabled selected>Docente...</option>');

                        if (data.length > 0) {
                           // Adiciona as opções ao select
                            $.each(data, function(index, teacher) {
                                $('#teacher').append('<option value="' + teacher.cpf + '">' + teacher.name + '</option>');
                        });
                    }
                    }
                });
            } else {
                // Se não houver categoria selecionada, limpar o select de produtos
                $('#subject').html('<option value="" disabled selected>Disciplina...</option>');
                $('#teacher').html('<option value="" disabled selected>Docente...</option>');
            }
        });

        $('#subject').change(function() {
            var subjectId = $(this).val();

            // Se uma categoria for selecionada
            if (subjectId) {
                $.ajax({
                    url: 'requests/get_classes.php',
                    type: 'POST',
                    data: { subject_id: subjectId },
                    dataType: 'json',
                    success: function(data) {
                        // Limpa o segundo select antes de adicionar as novas opções
                        $('#classes-list').html('');

                        if (data.length > 0) {
                           // Adiciona as opções ao select
                            $.each(data, function(index, subject) {
                                $('#classes-list').append('<li>' + subject.subject_name + ' - ' + subject.teacher_name + '</li>');
                        });
                    }
                    }
                });
            } else {
                // Se não houver categoria selecionada, limpar o select de produtos
                $('#classes-list').html('');
            }
        });
    </script>
</body>
</html>