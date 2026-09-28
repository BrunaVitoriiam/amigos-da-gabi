<?php

require_once "config.php";

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");

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

        $sql = "INSERT INTO amigos
                (usuario_id, nome, email, telefone)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_SESSION["usuario_id"],
            $nome,
            $email,
            $telefone
        ]);

        header(
            "Location: dashboard.php?sucesso=" .
            urlencode("Amigo cadastrado com sucesso!")
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

    <title>Novo Amigo - Amigos da Gabi</title>

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
            Cadastrar amigo
        </h1>

        <p>
            Adicione um novo amigo à sua lista.
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
                required
            >

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                required
            >

            <label>
                Telefone
            </label>

            <input
                type="text"
                name="telefone"
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
                    Cadastrar
                </button>

            </div>

        </form>

    </div>

</main>

</body>

</html>
