<?php
require_once "../infra/conexao.php";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $especie = trim($_POST["especie"] ?? "");
    $idade = $_POST["idade"] ?? 0;
    $id_cliente = $_POST["cliente_id"] ?? null;
 
    if (!empty($nome) && !empty($especie) && $idade > 0 && !empty($id_cliente)) {
        $stmt = $conexao->prepare("INSERT INTO CACHORRO (nome, especie, idade, id_cliente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $nome, $especie, $idade, $id_cliente);
        $stmt->execute();
        $stmt->close();
    }
}
 
header("Location: ../index.php");
exit;