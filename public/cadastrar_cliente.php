<?php

require_once "../infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (!empty($nome)) {
        $stmt = $conexao->prepare("INSERT INTO CLIENTE (nome, telefone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $telefone, $email);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../index.php");