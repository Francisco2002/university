<?php require_once "db/connection.php" ?>

<?php
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
    <title>Nova disciplina</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div>
        <h1>Adicionar Disciplina</h1>

        <?php
            if(isset($_GET['success'])) {
                echo "<p>Disciplina criada com sucesso!!</p>";
            }
        ?>

        <form method="POST" action="actions/create_subject.php">
            <select name="institute_id" required id="institute">
                <option value="" disabled selected>Instituto...</option>
                <?php
                    foreach ($institutes as $institute)
                        echo "<option value='".$institute['id']."'>".$institute['name']."</option>";
                ?>
            </select>
            <input disabled id="name" name="name" required placeholder="Nome da Disciplina" />
            <input disabled id="acronym" name="acronym" required placeholder="Sigla" />

            <button type="submit">Salvar</button>
        </form>
        
        <ul id="subjects_list"></ul>
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
                        $('#subjects_list').html('');

                        if (data.length > 0) {
                           // Adiciona as opções ao select
                            $.each(data, function(index, subject) {
                                $('#subjects_list').append('<li>' + subject.id + ": " + subject.name + '</li>');
                        });

                        $('#name').prop("disabled", false);
                        $('#acronym').prop("disabled", false);

                    }
                    }
                });

            } else {
                $('#subjects_list').html('');
            }
        });
    </script>
</body>
</html>