<?php

require_once "config.php";

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");

    exit;
}

$usuarioId = $_SESSION["usuario_id"];

$sql = "SELECT *
        FROM amigos
        WHERE usuario_id = ?
        ORDER BY nome ASC";

$stmt = $pdo->prepare($sql);

$stmt->execute([$usuarioId]);

$amigos = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Painel - Amigos da Gabi</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header class="topbar">

    <div>

        <strong>
            Amigos da Gabi
        </strong>

        <span>
            | Cadastro de Amigos
        </span>

    </div>

    <div>

        Olá,
        <strong>
            <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>
        </strong>

        <a class="logout" href="logout.php">
            Sair
        </a>

    </div>

</header>

<main class="container">

    <div class="page-header">

        <div>

            <h1>
                Meus amigos
            </h1>

            <p>
                Gerencie seus contatos através do CRUD.
            </p>

        </div>

        <a
            class="button"
            href="amigo_cadastrar.php"
        >
            + Novo amigo
        </a>

    </div>

    <?php if (isset($_GET["sucesso"])): ?>

        <div class="alert success">
            <?= htmlspecialchars($_GET["sucesso"]) ?>
        </div>

    <?php endif; ?>

    <?php if (count($amigos) === 0): ?>

        <div class="empty">

            <h2>
                Nenhum amigo cadastrado
            </h2>

            <p>
                Comece adicionando seu primeiro amigo.
            </p>

            <a
                class="button"
                href="amigo_cadastrar.php"
            >
                Cadastrar amigo
            </a>

        </div>

    <?php else: ?>

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach ($amigos as $amigo): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($amigo["nome"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($amigo["email"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($amigo["telefone"]) ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    class="button small edit"
                                    href="amigo_editar.php?id=<?= $amigo["id"] ?>"
                                >
                                    Editar
                                </a>

                                <a
                                    class="button small delete"
                                    href="amigo_excluir.php?id=<?= $amigo["id"] ?>"
                                    onclick="return confirm('Deseja realmente excluir este amigo?');"
                                >
                                    Excluir
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</main>

</body>

</html>
