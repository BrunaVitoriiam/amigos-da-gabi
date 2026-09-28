<?php

require_once "config.php";

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");
    exit;
}

$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT
);

if (!$id) {

    header("Location: dashboard.php");
    exit;
}

$sql = "DELETE FROM amigos
        WHERE id = ?
        AND usuario_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $id,
    $_SESSION["usuario_id"]
]);

header(
    "Location: dashboard.php?sucesso=" .
    urlencode("Amigo excluído com sucesso!")
);

exit;
