<?php

include "../infra/conexao.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $stmt = $conexao->prepare("DELETE FROM CLIENTE WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: listar_cliente.php");
    exit;

} else {

    header("Location: listar_cliente.php");
    exit;

}

?>