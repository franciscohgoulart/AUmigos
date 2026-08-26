<?php

include "infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cadastrar_cliente"])) {

    $nome = $_POST["nome"];
    $email = $_POST["email"];

    $stmt = $conexao->prepare("INSERT INTO CLIENTE (nome, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $email);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$cliente = mysqli_query($conexao, "SELECT * FROM CLIENTE ORDER BY id DESC");

$cachorro = mysqli_query($conexao, "
    SELECT 
        ANIMAL.id,
        ANIMAL.nome,
        ANIMAL.especie,
        ANIMAL.idade,
        CLIENTE.nome AS cliente_nome
    FROM ANIMAL
    INNER JOIN CLIENTE ON ANIMAL.cliente_id = CLIENTE.id
    ORDER BY ANIMAL.id DESC
");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - AUmigos</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <header>
        <center>
            <h1>CRUD - AUmigos</h1>
        </center>

        <nav>
            <center>
            <a href="index.php">Início</a> |
            <a href="public/listar_clientes.php">Gerenciar Clientes</a> |
            <a href="public/listar_animais.php">Gerenciar Animais</a>
            </center>
        </nav>

<br>

    </header>

    <main>

        <center>
            <h2>Cadastrar Cliente</h2>
        </center>

        <form action="index.php" method="POST">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <br>

            <button type="submit" name="cadastrar_cliente">
                Cadastrar Cliente
            </button>

        </form>

        

        <center>
            <h2>Cadastrar Animal</h2>
        </center>

        <form action="public/cadastrar_animais.php" method="POST">

            <label for="nome_animal">Nome:</label>
            <input type="text" id="nome_animal" name="nome" required>

            <br>

            <label for="especie">Espécie:</label>
            <input type="text" id="especie" name="especie" required>

            <br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0" required>

            <br>

            <label for="cliente_id">Responsável:</label>

            <select id="cliente_id" name="cliente_id" required>

                <option value="">Selecione um cliente</option>

                <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>

                    <option value="<?php echo $cliente["id"]; ?>">
                        <?php echo htmlspecialchars($cliente["nome"]); ?>
                    </option>

                <?php } ?>

            </select>

            <br>

            <button type="submit">
                Cadastrar Animal
            </button>

        </form>

    

        <center>
            <h2>Animais Cadastrados</h2>
        </center>

        <table>

            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Idade</th>
                <th>Responsável</th>
            </tr>

            <?php while ($animal = mysqli_fetch_assoc($animais)) { ?>

                <tr>

                    <td>
                        <?php echo $animal["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($animal["nome"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($animal["especie"]); ?>
                    </td>

                    <td>
                        <?php echo $animal["idade"]; ?> anos
                    </td>

                    <td>
                        <?php echo htmlspecialchars($animal["cliente_nome"]); ?>
                    </td>

                

                </tr>

            <?php } ?>

        </table>

    </main>

    <footer>

    </footer>

</body>

</html>