<?php

require_once "config.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($nome) || empty($email) || empty($senha)) {

        $erro = "Preencha todos os campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Digite um e-mail válido.";

    } elseif (strlen($senha) < 6) {

        $erro = "A senha deve possuir pelo menos 6 caracteres.";

    } else {

        $verificar = $pdo->prepare(
            "SELECT id FROM usuarios WHERE email = ?"
        );

        $verificar->execute([$email]);

        if ($verificar->fetch()) {

            $erro = "Este e-mail já está cadastrado.";

        } else {

            $senhaHash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO usuarios
                    (nome, email, senha)
                    VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $nome,
                $email,
                $senhaHash
            ]);

            $sucesso =
                "Cadastro realizado com sucesso! Agora você pode fazer login.";
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

    <title>Cadastro - Amigos da Gabi</title>

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
            Criar conta
        </h2>

        <?php if ($erro): ?>

            <div class="alert error">
                <?= htmlspecialchars($erro) ?>
            </div>

        <?php endif; ?>

        <?php if ($sucesso): ?>

            <div class="alert success">
                <?= htmlspecialchars($sucesso) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label>
                Nome
            </label>

            <input
                type="text"
                name="nome"
                placeholder="Digite seu nome"
                required
            >

            <label>
                E-mail
            </label>

            <input
                type="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
            >

            <label>
                Senha
            </label>

            <input
                type="password"
                name="senha"
                placeholder="Mínimo 6 caracteres"
                required
            >

            <button type="submit">
                Criar conta
            </button>

        </form>

        <p class="auth-link">

            Já possui uma conta?

            <a href="login.php">
                Fazer login
            </a>

        </p>

    </div>

</div>

</body>

</html>
