<?php
session_start();
require_once '../model/Campos.php';

if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.html');
    exit;
}

$camposModel = new Campos();
$id_cliente = $_SESSION['id_cliente'];
$campos = $camposModel->getCamposByProprietario($id_cliente);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Administração</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery e JS custom -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/administrador.js"></script>

    <!-- CSS custom -->
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <header class="fundoNav shadow-sm">
        <div class="container d-flex justify-content-between align-items-center h-100">
            <div class="d-flex align-items-center gap-3">
                <img src="../public/images/FutAgenda.png" width="80" height="80" alt="Logo FutAgenda"
                    class="rounded-circle bg-white p-1">
            </div>
            <nav class="navbar navbar-expand">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/administrador.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/cadastroCampos.php">Cadastrar Campos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/login.html">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container py-5">
        <h2 class="text-center fw-bold mb-4">Meus Campos Cadastrados</h2>

        <?php if (count($campos) === 0): ?>
            <div class="alert alert-warning text-center">Nenhum campo cadastrado ainda.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Nome</th>
                            <th>Início Operação</th>
                            <th>Fim Operação</th>
                            <th>Preço (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campos as $campo): ?>
                            <tr>
                                <td><?= htmlspecialchars($campo['nome']) ?></td>
                                <td><?= date('H:i', strtotime($campo['inicio_operacao'])) ?></td>
                                <td><?= date('H:i', strtotime($campo['fim_operacao'])) ?></td>
                                <td>R$<?= number_format($campo['preco_slot'], 2, ',', '.') ?></td>
                                <td class="text-center">
                                    <a href="../controller/deletarCampo.php?id=<?= $campo['id_campo'] ?>"
                                        class="btn btn-outline-danger btn-sm px-3 rounded-3"
                                        onclick="return confirm('Tem certeza que deseja excluir este campo?');">
                                        Excluir
                                    </a>
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