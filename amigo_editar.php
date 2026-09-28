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

$sql = "SELECT *
        FROM amigos
        WHERE id = ?
        AND usuario_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $id,
    $_SESSION["usuario_id"]
]);

$amigo = $stmt->fetch();

if (!$amigo) {

    header("Location: dashboard.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);

    if (
        empty($nome) ||
        empty($email) ||
        empty($telefone)
    ) {

        $erro = "Preencha todos os campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Digite um e-mail válido.";

    } else {

        $sql = "UPDATE amigos
                SET nome = ?,
                    email = ?,
                    telefone = ?
                WHERE id = ?
                AND usuario_id = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $email,
            $telefone,
            $id,
            $_SESSION["usuario_id"]
        ]);

        header(
            "Location: dashboard.php?sucesso=" .
            urlencode("Amigo atualizado com sucesso!")
        );

        exit;
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Amigo - Amigos da Gabi</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header class="topbar">

    <strong>
        Amigos da Gabi
    </strong>

    <a class="logout" href="dashboard.php">
        Voltar
    </a>

</header>

<main class="container">

    <div class="form-card">

        <h1>
            Editar amigo
        </h1>

        <p>
            Atualize as informações do contato.
        </p>

        <?php if ($erro): ?>

            <div class="alert error">
                <?= htmlspecialchars($erro) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label>
                Nome
            </label>

            <input
                type="text"
                name="nome"
                value="<?= htmlspecialchars($amigo["nome"]) ?>"
                required
            >

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($amigo["email"]) ?>"
                required
            >

            <label>
                Telefone
            </label>

            <input
                type="text"
                name="telefone"
                value="<?= htmlspecialchars($amigo["telefone"]) ?>"
                required
            >

            <div class="form-actions">

                <a
                    class="button secondary"
                    href="dashboard.php"
                >
                    Cancelar
                </a>

                <button
                    class="button"
                    type="submit"
                >
                    Salvar alterações
                </button>

            </div>

        </form>

    </div>

</main>

</body>

</html>
