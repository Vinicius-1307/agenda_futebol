<?php
session_start();
require_once '../model/Campos.php';

if (!isset($_SESSION['id_cliente']) || !isset($_GET['id'])) {
    header('Location: login.html');
    exit;
}

$campoModel = new Campos();
$campo = $campoModel->getById($_GET['id']);

// Verifica se o campo existe e pertence ao usuário logado
if (!$campo || $campo->getId_cliente() != $_SESSION['id_cliente']) {
    header('Location: meusCampos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Editar Campo</title>

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
                        <a class="nav-link fw-semibold" href="../view/administrador.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/meusCampos.php">Meus Campos</a>
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
        <h2 class="tituloHome fw-bold text-center mb-5">Editar Campo</h2>

        <form action="../controller/editarCampoController.php" method="POST" enctype="multipart/form-data" id="formCampo" class="mx-auto" style="max-width: 800px;">
            <input type="hidden" name="id_campo" value="<?php echo $campo->getId_campo(); ?>">
            
            <div class="row g-3 justify-content-center">
                <!-- Nome do campo -->
                <div class="col-md-12">
                    <label for="nome" class="form-label">Nome do campo:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                        placeholder="Ex: Campo Society A" value="<?php echo htmlspecialchars($campo->getNome()); ?>">
                </div>

                <!-- Descrição -->
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"
                        placeholder="Ex: Campo gramado com iluminação, vestiários, estacionamento..."><?php echo htmlspecialchars($campo->getDescricao() ?? ''); ?></textarea>
                </div>

                <!-- Imagem atual -->
                <?php if ($campo->getImagem()): ?>
                    <div class="col-md-12">
                        <label class="form-label">Imagem atual:</label>
                        <div class="border rounded p-2">
                            <img src="../public/images/<?php echo htmlspecialchars($campo->getImagem()); ?>" 
                                 alt="Imagem atual" 
                                 class="img-thumbnail" 
                                 style="max-height: 200px; object-fit: cover;">
                        </div>
                        <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($campo->getImagem()); ?>">
                    </div>
                <?php endif; ?>

                <!-- Nova Imagem -->
                <div class="col-md-12">
                    <label for="imagem" class="form-label">
                        <?php echo $campo->getImagem() ? 'Alterar imagem:' : 'Adicionar imagem:'; ?>
                    </label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                    <small class="text-muted">Formatos aceitos: JPG, PNG, GIF, WEBP. Deixe em branco para manter a imagem atual.</small>
                </div>

                <!-- Início operação -->
                <div class="col-md-4">
                    <label for="inicio_operacao" class="form-label">Início de operação:</label>
                    <input type="time" class="form-control" id="inicio_operacao" name="inicio_operacao" required step="3600"
                        value="<?php echo date('H:i', strtotime($campo->getInicio_atendimento())); ?>">
                </div>

                <!-- Fim operação -->
                <div class="col-md-4">
                    <label for="fim_operacao" class="form-label">Fim de operação:</label>
                    <input type="time" class="form-control" id="fim_operacao" name="fim_operacao" required step="3600"
                        value="<?php echo date('H:i', strtotime($campo->getFim_atendimento())); ?>">
                </div>

                <!-- Preço do jogo -->
                <div class="col-md-4">
                    <label for="preco_slot" class="form-label">Preço por jogo (R$):</label>
                    <input type="number" class="form-control" id="preco_slot" name="preco_slot" required step="0.01" 
                        placeholder="Ex: 100.00" value="<?php echo number_format($campo->getPreco_slot(), 2, '.', ''); ?>">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="../view/meusCampos.php" class="btn btn-secondary rounded-3 px-4">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary rounded-3 px-4">
                    Salvar Alterações
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
