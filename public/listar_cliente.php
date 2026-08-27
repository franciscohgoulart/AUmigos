<?php
require_once "../infra/conexao.php";

$cliente = $conexao->query("SELECT * FROM cliente");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Clientes Cadastrados</h2>
    <a href="../index.php">Voltar</a>
    <table border="1">
        <tr>
            <th>ID</th><th>Nome</th><th>E-mail</th><th>Ações</th>
        </tr>
        <?php while ($u = $cliente->fetch_assoc()): ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo $u['nome']; ?></td>
                <td><?php echo $u['email']; ?></td>
                <td>
                     <a href="listar_animal.php?cliente_id=<?php echo $u['id']; ?>">Ver animais</a>
    <a href="editar_cliente.php?id=<?php echo $u['id']; ?>">Editar</a>
    <a href="excluir_cliente.php?id=<?php echo $u['id']; ?>"
       onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
        Excluir
    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>