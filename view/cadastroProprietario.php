<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Cadastrar Proprietário</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bibliotecas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Importa seu arquivo JS -->
    <script src="../public/js/utils.js"></script>

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
                        <a class="nav-link fw-semibold" href="../view/administrador.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/cadastroServico.php">Cadastrar Serviço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/servicosAdm.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/login.html">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="container py-5">
        <h2 class="tituloHome fw-bold text-center mb-5">Cadastrar Proprietário</h2>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <form action="../controller/ProprietarioController.php" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label for="nome" class="form-label required">Nome</label>
                            <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" name="nome" required>
                        </div>
                        <div>
                            <label for="cpf" class="form-label required">CPF</label>
                            <input type="text" class="form-control" id="cpf" placeholder="Digite seu CPF" name="cpf" required>
                        </div>
                        <div>
                            <label for="rg" class="form-label required">RG</label>
                            <input type="text" class="form-control" id="rg" placeholder="Digite seu RG" name="rg" required>
                        </div>
                        <div>
                            <label for="telefone" class="form-label required">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" placeholder="Digite seu telefone" name="telefone" required>
                        </div>
                        <div>
                            <label for="email" class="form-label required">E-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" name="email" required>
                        </div>
                        <div>
                            <label for="senha" class="form-label required">Senha</label>
                            <input type="password" class="form-control" id="senha" placeholder="Digite sua senha" name="senha" required>
                        </div>
                        <div class="d-flex justify-content-start">
                            <span class="small text-danger">* Campos obrigatórios</span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
    <?php include 'mensagem.php'; ?>
</body>

</html>