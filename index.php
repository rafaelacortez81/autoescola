
<?php

include "config.php";

function create($nome, $email, $telefone, $data_nascimento) {
    global $pdo;

    $sql = "INSERT INTO Alunos 
    (nome, email, telefone, data_nascimento) 
    VALUES (:nome, :email, :telefone, :data_nascimento)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":nome", $nome);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":telefone", $telefone);
    $stmt->bindValue(":data_nascimento", $data_nascimento);

    return $stmt->execute();
}


function read() {
    global $pdo;

    $sql = "SELECT * FROM Alunos";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];

    if (create($nome, $email, $telefone, $data_nascimento)) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autoescola - Alunos</title>
</head>
<body>

    <h1>Cadastro de Alunos</h1>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <br><br>

        <input type="email" name="email" placeholder="E-mail" required>
        <br><br>

        <input type="text" name="telefone" placeholder="Telefone">
        <br><br>

        <label>Data de nascimento:</label>
        <input type="date" name="data_nascimento" required>
        <br><br>

        <button type="submit">Cadastrar Aluno</button>
    </form>

    <hr>

    <h2>Alunos Cadastrados</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Data de Nascimento</th>
        </tr>

        <?php
        $alunos = read();

        foreach ($alunos as $aluno) {
        ?>

        <tr>
            <td><?php echo $aluno["id"]; ?></td>
            <td><?php echo htmlspecialchars($aluno["nome"]); ?></td>
            <td><?php echo htmlspecialchars($aluno["email"]); ?></td>
            <td><?php echo htmlspecialchars($aluno["telefone"] ?? ""); ?></td>
            <td><?php echo $aluno["data_nascimento"]; ?></td>
        </tr>

        <?php
        }
        ?>

    </table>

</body>
</html>
