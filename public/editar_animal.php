<?php
require_once "../infra/conexao.php";

// Processa o formulário quando enviado (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"] ?? null;
    $nome = trim($_POST["nome"] ?? "");
    $especie = trim($_POST["especie"] ?? "");
    $idade = $_POST["idade"] ?? 0;
    $id_cliente = $_POST["cliente_id"] ?? null;

    if (!empty($id) && !empty($nome) && !empty($especie) && $idade > 0 && !empty($id_cliente)) {
        $stmt = $conexao->prepare("UPDATE CACHORRO SET nome = ?, especie = ?, idade = ?, id_cliente = ? WHERE id = ?");
        $stmt->bind_param("ssiii", $nome, $especie, $idade, $id_cliente, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: listar_animal.php");
    exit;
}

// Busca os dados do animal para preencher o formulário (GET)
$id = $_GET["id"] ?? null;

if (empty($id)) {
    header("Location: listar_animal.php");
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM CACHORRO WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$animal = $resultado->fetch_assoc();
$stmt->close();

if (!$animal) {
    header("Location: listar_animal.php");
    exit;
}

$clientes = $conexao->query("SELECT * FROM CLIENTE ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <h2>Editar Animal</h2>

    <a href="listar_animal.php">Voltar</a>

    <br><br>

    <form action="editar_animal.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $animal["id"]; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($animal["nome"]); ?>" required>

        <br>

        <label for="especie">Espécie:</label>
        <input type="text" id="especie" name="especie" value="<?php echo htmlspecialchars($animal["especie"]); ?>" required>

        <br>

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" min="0" value="<?php echo $animal["idade"]; ?>" required>

        <br>

        <label for="cliente_id">Responsável:</label>

        <select id="cliente_id" name="cliente_id" required>

            <?php while ($cli = mysqli_fetch_assoc($clientes)) { ?>

                <option value="<?php echo $cli["id"]; ?>" <?php echo ($cli["id"] == $animal["id_cliente"]) ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($cli["nome"]); ?>
                </option>

            <?php } ?>

        </select>

        <br>

        <button type="submit">
            Salvar Alterações
        </button>

    </form>

</body>

</html>