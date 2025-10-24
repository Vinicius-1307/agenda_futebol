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
                        <a class="nav-link fw-semibold" href="../view/login.html">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="container py-5">
        <h2 class="tituloHome fw-bold text-center mb-5">Cadastrar Campo</h2>

        <form action="../controller/CampoController.php" method="POST" enctype="multipart/form-data" id="formCampo" class="mx-auto" style="max-width: 800px;">
            <div class="row g-3 justify-content-center">
                <!-- Nome do campo -->
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome do campo:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                        placeholder="Ex: Campo Society A">
                </div>

                <!-- Início operação -->
                <div class="col-md-3">
                    <label for="inicio_operacao" class="form-label">Início de operação:</label>
                    <input type="time" class="form-control" id="inicio_operacao" name="inicio_operacao" required step="3600">
                </div>

                <!-- Fim operação -->
                <div class="col-md-3">
                    <label for="fim_operacao" class="form-label">Fim de operação:</label>
                    <input type="time" class="form-control" id="fim_operacao" name="fim_operacao" required step="3600">
                </div>

                <!-- Duração do slot -->
                <div class="col-md-4">
                    <label for="duracao_slot" class="form-label">Duração do jogo (minutos):</label>
                    <input type="number" class="form-control" id="duracao_slot" name="duracao_slot"
                        required min="10" step="5" placeholder="Ex: 60">
                </div>

                <!-- Preço do jogo -->
                <div class="col-md-4">
                    <label for="preco_slot" class="form-label">Preço por jogo (R$):</label>
                    <input type="number" class="form-control" id="preco_slot" name="preco_slot" required step="0.01" placeholder="Ex: 100.00">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary rounded-3 px-4">
                    Salvar
                </button>
            </div>
        </form>
    </main>
    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
</body>

</html>
<script>
    // Impede horários quebrados (minutos diferentes de 00)
    const timeFields = document.querySelectorAll('#inicio_operacao, #fim_operacao');

    timeFields.forEach(field => {
        field.addEventListener('change', () => {
            const [hour, minute] = field.value.split(':');
            if (minute !== "00") {
                // Corrige automaticamente para o horário cheio
                field.value = `${hour.padStart(2, '0')}:00`;
                alert("Por favor, selecione apenas horários exatos (ex: 08:00, 09:00, etc).");
            }
        });
    });
</script>