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
                    <a class="nav-link" href="../view/cadastroBarbeiro.html">Cadastrar Barbeiro</a>
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

    <h2 class="tituloHome mt-3">Cadastro Serviço</h2>

    <div class="container formulario">
        <form action="../controller/cadastroServico.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="nome" class="form-label">Serviço:</label>
                <input type="text" class="form-control" id="nomeServico" required placeholder="Nome do serviço" name="nomeServico">
            </div>
            <div class="mb-3">
                <label for="profissional" class="form-label">Profissional:</label>
                <select class="form-control" id="profissional" name="profissional" required>
                    <option value="" disabled selected>Selecione um profissional</option>
                    <?php
                        session_start();
                        include_once('../model/Profissionais.php');
                        if($_SESSION['is_admin'] == 1){
                            $profissional = new Profissionais();
                            foreach ($profissional->readAll() as $prof) {
                                echo '<option value="' . ($prof->getId_prof()) . '">' . htmlspecialchars($prof->getNome()) . '</option>';
                            }
                        } else {
                            echo '<option value="' . ($_SESSION['id_prof']) . '">' . $_SESSION['nomeBarbeiro'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" class="form-control" id="preco" required placeholder="Digite o preço que o barbeiro cobra" name="preco">
            </div>
            <div class="mb-3">
                <label for="duracao">Duração serviço: (Minutos)</label><br>
                <input type="time" class="form-control" id="tempo" required name="tempo" min="0" max="60" placeholder="Minutos">
            </div>
            <div class="mb-3">
                <label for="duracao">Fotos serviço:</label><br>
                <input type="file" class="form-control" id="fotos" name="fotos[]">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        <p></p>
    </div>
</body>

</html>