<?php
require_once "../infra/conexao.php";

// Processa a atualização quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"] ?? null;
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (!empty($id) && !empty($nome) && !empty($email)) {
        $stmt = $conexao->prepare("UPDATE CLIENTE SET nome = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $email, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: listar_cliente.php");
    exit;
}

// Busca os dados do cliente pra preencher o formulário
$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: listar_cliente.php");
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM CLIENTE WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cliente) {
    header("Location: listar_cliente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

    <h2>Editar Cliente</h2>

    <form action="editar_cliente.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>

        <br>

        <label>E-mail:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>

        <br>

        <button type="submit">Salvar Alterações</button>

    </form>

    <br>

    <a href="listar_cliente.php">Voltar</a>

</body>
</html>