<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Cadastrar Campo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS custom -->
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <header class="fundoNav shadow-sm">
        <div class="container d-flex justify-content-between align-items-center h-100">
            <div class="d-flex align-items-center gap-3">
                <img src="../public/images/FutAgenda.png" width="80" height="80" alt="Logo FutAgenda"
                    class="rounded-circle bg-white p-1">
            </div>
            <nav class="navbar navbar-expand">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <?php
                        session_start();
                        $rota = $_SESSION['is_admin'] == 1
                            ? "<a class='nav-link fw-semibold' href='../view/administrador.php'>Home</a>"
                            : "<a class='nav-link fw-semibold' href='../view/agendasBarbeiro.php'>Meus horários</a>";
                        echo $rota;
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        $rota = $_SESSION['is_admin'] == 1
                            ? "<a class='nav-link fw-semibold' href='../view/servicosAdm.php'>Serviços</a>"
                            : "<a class='nav-link fw-semibold' href='../view/servicosBarbeiro.php'>Serviços</a>";
                        echo $rota;
                        ?>
                    </li>
                    <?php if ($_SESSION['is_admin'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="../view/cadastroProprietario.php">Cadastrar Proprietário</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/login.html">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="container py-5">
        <h2 class="tituloHome fw-bold text-center mb-5">Cadastrar Campo</h2>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <form action="../controller/CampoController.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nomeCampo" class="form-label">Campo:</label>
                        <input type="text" class="form-control" id="nomeCampo" name="nomeCampo" required placeholder="Nome do campo">
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço (R$ / hora):</label>
                        <input type="number" class="form-control" id="preco" name="preco" required placeholder="Digite o preço da hora do campo">
                    </div>
                    <div class="mb-3">
                        <label for="tempo" class="form-label">Duração jogo (minutos):</label>
                        <input type="time" class="form-control" id="tempo" name="tempo" required>
                    </div>
                    <div class="mb-3">
                        <label for="fotos" class="form-label">Fotos do campo:</label>
                        <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
</body>

</html>