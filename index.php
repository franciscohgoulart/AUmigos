<?php

require_once "infra/conexao.php";

// Busca todos os clientes
$cliente = $conexao->query("SELECT id, nome, telefone, email FROM CLIENTE ORDER BY nome");

// Busca todos os animais
$cachorro = $conexao->query("SELECT id, nome, especie, idade, id_cliente FROM cachorro ORDER BY nome");
// Lista de clientes para popular o <select> do formulário de animal

$clientes_select = $conexao->query("SELECT id, nome FROM CLIENTE ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aumigos - Painel</title>
</head>
<body>

    <h1>Clientes</h1>

    <form action="paginas/cadastrar_cliente.php" method="POST">
        <input type="text" name="nome" placeholder="Nome do cliente" required>
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <button type="submit">Cadastrar cliente</button>
    </form>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>

        <?php while ($cliente = $cliente->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($cliente["id"]) ?></td>
            <td><?= htmlspecialchars($cliente["nome"]) ?></td>
            <td><?= htmlspecialchars($cliente["telefone"]) ?></td>
            <td><?= htmlspecialchars($cliente["email"]) ?></td>
            <td>
                <a href="paginas/editar_cliente.php?id=<?= $cliente["id"] ?>">Editar</a>
                |
                <a href="paginas/excluir_cliente.php?id=<?= $cliente["id"] ?>"
                   onclick="return confirm('Excluir este cliente?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <hr>

    <h1>Animais</h1>

    <form action="paginas/cadastrar_animal.php" method="POST">
        <input type="text" name="nome" placeholder="Nome do animal" required>
        <input type="text" name="especie" placeholder="Espécie (cachorro, gato...)" required>
        <input type="number" name="idade" placeholder="Idade" required>
        <select name="id_cliente" required>
            <option value="">Selecione o responsável</option>
            <?php while ($c = $clientes_select->fetch_assoc()): ?>
                <option value="<?= $c["id"] ?>"><?= htmlspecialchars($c["nome"]) ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Cadastrar animal</button>
    </form>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Idade</th>
            <th>Responsável</th>
            <th>Ações</th>
        </tr>
        <?php while ($c = $cachorro->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($cachorro["id"]) ?></td>
            <td><?= htmlspecialchars($cachorro["nome"]) ?></td>
            <td><?= htmlspecialchars($cachorro["especie"]) ?></td>
            <td><?= htmlspecialchars($cachorro["idade"]) ?></td>
            <td><?= $cachorro["responsavel"] ? htmlspecialchars($cachorro["responsavel"]) : "<em>sem responsável</em>" ?></td>
            <td>
                <a href="paginas/editar_animal.php?id=<?= $cachorro["id"] ?>">Editar</a>
                |
                <a href="paginas/excluir_animal.php?id=<?= $cachorro["id"] ?>"
                   onclick="return confirm('Excluir este animal?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>