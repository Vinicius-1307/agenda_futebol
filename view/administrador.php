<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../public/js/administrador.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>FutAgenda</title>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../view/cadastroProprietario.php">Cadastrar Barbeiro</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../view/cadastroCampos.php">Cadastrar Campos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/servicosAdm.php">Campos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/login.html">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="tituloHome mt-3">Home</h2>

    <?php
    require_once '../model/Profissionais.php';

    $profissional = new Profissionais();
    $profissionais = $profissional->readAll();
    ?>

    <div class="main-content">
        <div class="container mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Profissional</th>
                        <th scope="col" class="text-center">CPF</th>
                        <th scope="col" class="text-center">RG</th>
                        <th scope="col" class="text-center">Telefone</th>
                        <th scope="col" class="text-center">Ano Cadastro</th>
                        <th scope="col" class="text-center">E-mail</th>
                        <th scope="col" class="text-center">Início Atendimento</th>
                        <th scope="col" class="text-center">Fim Atendimento</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profissionais as $index => $profissional) : ?>
                        <tr>
                            <td class="text-center"><?php echo $profissional->getNome(); ?></td>
                            <td class="text-center"><?php echo $profissional->getCpf(); ?></td>
                            <td class="text-center"><?php echo $profissional->getRg(); ?></td>
                            <td class="text-center"><?php echo $profissional->getTelefone(); ?></td>
                            <td class="text-center"><?php echo $profissional->getAno_cadastro(); ?></td>
                            <td class="text-center"><?php echo $profissional->getEmail(); ?></td>
                            <td class="text-center"><?php echo $profissional->getInicio_atendimento(); ?></td>
                            <td class="text-center"><?php echo $profissional->getFim_atendimento(); ?></td>
                            <td class="text-center"><button onclick="excluirProfissional(<?php echo $profissional->getId_prof(); ?>)" type="button" class="btn btn-outline-danger">Excluir</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        © 2025 FutAgenda
    </div>
</body>

</html>