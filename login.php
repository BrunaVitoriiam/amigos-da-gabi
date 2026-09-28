<?php

require_once "config.php";

if (isset($_SESSION["usuario_id"])) {

    header("Location: dashboard.php");
    exit;

}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($email) || empty($senha)) {

        $erro = "Preencha e-mail e senha.";

    } else {

        $sql = "SELECT id, nome, email, senha
                FROM usuarios
                WHERE email = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$email]);

        $usuario = $stmt->fetch();

        if (
            $usuario &&
            password_verify($senha, $usuario["senha"])
        ) {

            session_regenerate_id(true);

            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            $_SESSION["usuario_email"] = $usuario["email"];

            header("Location: dashboard.php");

            exit;

        } else {

            $erro = "E-mail ou senha incorretos.";

        }
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - Amigos da Gabi</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="logo-circle">
            AG
        </div>

        <h1>
            Amigos da Gabi
        </h1>

        <p class="subtitle">
            Sistema de Cadastro de Amigos
        </p>

        <h2>
            Login
        </h2>

        <?php if ($erro): ?>

            <div class="alert error">
                <?= htmlspecialchars($erro) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                placeholder="seu@email.com"
                required
            >

            <label>
                Senha
            </label>

            <input
                type="password"
                name="senha"
                placeholder="Digite sua senha"
                required
            >

            <button type="submit">
                Entrar
            </button>

        </form>

        <p class="auth-link">

            Ainda não possui uma conta?

            <a href="cadastro.php">
                Criar conta
            </a>

        </p>

    </div>

</div>

</body>

</html>
