<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>FutAgenda</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php
                    session_start();
                    $rota = $_SESSION['is_admin'] == 1 ?
                        "<a class='nav-link' href='../view/administrador.php'>Home</a>" :
                        "<a class='nav-link' href='../view/agendasBarbeiro.php'>Meus horários</a>";
                    echo $rota;
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    $rota = $_SESSION['is_admin'] == 1 ?
                        "<a class='nav-link' href='../view/servicosAdm.php'>Serviços</a>" :
                        "<a class='nav-link' href='../view/servicosBarbeiro.php'>Serviços</a>";
                    echo $rota;
                    ?>
                </li>

                <?php if ($_SESSION['is_admin'] == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/cadastroProprietario.php">Cadastrar Proprietário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/servicosAdm.php">Serviços</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="../view/login.html">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="tituloHome mt-3">Cadastrar Campo</h2>
    <div class="main-content">
        <div class="container formulario">
            <form action="../controller/CampoController.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="nome" class="form-label">Campo:</label>
                    <input type="text" class="form-control" id="nomeCampo" required placeholder="Nome do campo" name="nomeCampo">
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço:</label>
                    <input type="number" class="form-control" id="preco" required placeholder="Digite o preço da hora do campo" name="preco">
                </div>
                <div class="mb-3">
                    <label for="duracao">Duração jogo: (Minutos)</label><br>
                    <input type="time" class="form-control" id="tempo" required name="tempo" min="0" max="60" placeholder="Minutos">
                </div>
                <div class="mb-3">
                    <label for="duracao">Fotos campo:</label><br>
                    <input type="file" class="form-control" id="fotos" name="fotos[]">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn-salvar">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        © 2025 FutAgenda
    </div>
</body>

</html>