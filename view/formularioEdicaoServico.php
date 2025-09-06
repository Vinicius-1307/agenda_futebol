<?php
session_start();
include_once '../model/Servicos.php'; 

$id_servico = $_GET['id_servico'];
$nome_servico = $_GET['nome_servico'];
$preco_servico = $_GET['preco_servico'];    
$tempo_servico = $_GET['tempo_servico'];
$foto_servico = $_GET['foto_servico'];

?>

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
    <title>Cardoso Barber</title>
</head>

<body>
    <div class="fundoNav p-4 text-center">
        <div class="top">
            <img src="../public/images/image.png" height="200px" width="400px" alt="">
        </div>
    </div>

    <nav class="navbar navbar-expand-sm navbar-dark">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../view/administrador.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/cadastroBarbeiro.html">Cadastrar Barbeiro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/cadastroServico.php">Cadastrar Serviço</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/servicosAdm.php">Serviços</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/login.html">Sair</a>
            </li>
        </ul>
    </div>
</nav>
    <h2 class="tituloHome mt-3">Editar Serviço</h2>
    <div class="container formulario">
    <form action="../controller/editarDadosServico.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_servico" value="<?php echo $id_servico; ?>">

        <div class="mb-3 mt-3">
            <label for="nome" class="form-label">Serviço:</label>
            <input type="text" class="form-control" id="nomeServico" name="nomeServico" value="<?php echo $nome_servico; ?>" required>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço:</label>
            <input type="number" class="form-control" id="preco" name="preco" value="<?php echo $preco_servico; ?>" required>
        </div>

        <div class="mb-3">
            <label for="duracao">Duração serviço: (Minutos)</label><br>
            <input type="time" class="form-control" id="tempo" name="tempo" value="<?php echo $tempo_servico; ?>" required>
        </div>

        <div class="mb-3">
            <label for="duracao">Fotos serviço:</label><br>
            <input type="file" class="form-control" id="fotos" accept="image/*" name="fotos[]">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        <p></p>
    </div>
</body>
</html>
