<?php
require_once "../infra/conexao.php";

$cliente = $conexao->query(" SELECT 
        cachorro.id,
        cachorro.nome,
        cachorro.especie,
        cachorro.idade,
        CLIENTE.nome AS cliente_nome
    FROM cachorro
    INNER JOIN CLIENTE ON cachorro.id_cliente = CLIENTE.id");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Animais</title>
      <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Animais Cadastrados</h2>
    <a href="../index.php">Voltar</a>
    <table border="1">
        <tr>
            <th>ID</th><th>Nome</th><th>Especies</th><th>Idade</th><th>Responsável</th><th>Ações</th>
        </tr>
        <?php while ($u = $cliente->fetch_assoc()): ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo $u['nome']; ?></td>
                <td><?php echo $u['especie']; ?></td>
                <td><?php echo $u['idade']; ?></td>
                <td><?php echo $u['cliente_nome']; ?></td>
                 <td>
    <a href="editar_animal.php?id=<?php echo $u['id']; ?>">Editar</a>
    <a href="excluir_animal.php?id=<?php echo $u['id']; ?>"
       onclick="return confirm('Tem certeza que deseja excluir este animal?')">
        Excluir
    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>