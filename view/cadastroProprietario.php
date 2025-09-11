<!DOCTYPE html>
<html lang="pt-br">
<?php include 'mensagem.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>FutAgenda</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../view/administrador.php">Home</a>
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

    <h2 class="tituloHome mt-3">Cadastrar Proprietário</h2>

    <div class="main-content">
        <div class="container formulario">
            <form action="../controller/ProprietarioController.php" method="POST">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label for="nome" class="form-label required">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" name="nome">
                    </div>
                    <div>
                        <label for="cpf" class="form-label required">CPF</label>
                        <input type="text" class="form-control" id="cpf" placeholder="Digite seu CPF" name="cpf">
                    </div>
                    <div>
                        <label for="rg" class="form-label required">RG</label>
                        <input type="text" class="form-control" id="rg" placeholder="Digite seu RG" name="rg">
                    </div>
                    <div>
                        <label for="email" class="form-label required">E-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite seu E-mail" name="email">
                    </div>
                    <div>
                        <label for="senha" class="form-label required">Senha</label>
                        <input type="password" class="form-control" id="senha" placeholder="Digite sua senha" name="senha">
                    </div>
                    <div>
                        <label for="telefone" class="form-label required">Telefone</label>
                        <input type="number" class="form-control" id="telefone" placeholder="Digite seu Telefone"
                            name="telefone">
                    </div>
                    <div class="d-flex justify-content-start">
                        <span class="small text-danger">Os campos marcados com * são obrigatórios</span>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-salvar">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        © 2025 FutAgenda
    </div>
</body>

</html>