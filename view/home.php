<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bibliotecas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Importa seu arquivo JS -->
    <script src="../public/js/utils.js"></script>

    <!-- CSS custom -->
    <link rel="stylesheet" href="/agenda_futebol/public/css/style.css">
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
                        <a class="nav-link fw-semibold" href="/agenda_futebol/view/agendasCliente.php">Meus horários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="/agenda_futebol/view/login.html">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="container py-5">
        <h2 class="tituloHome fw-bold text-center mb-5">Agendar Horários</h2>
        <div class="row g-4">
            <?php
            include_once __DIR__ . '/../model/Campos.php';
            $campoModel = new Campos();
            $campos = $campoModel->getAll();
            foreach ($campos as $campo) :
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 hover-card">
                        <?php if ($campo->getImagem()): ?>
                            <img src="../public/images/<?php echo htmlspecialchars($campo->getImagem()); ?>" 
                                 class="card-img-top rounded-top-4" 
                                 alt="<?php echo htmlspecialchars($campo->getNome()); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center rounded-top-4" 
                                 style="height: 200px;">
                                <div class="text-center text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image mb-2" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                    </svg>
                                    <p class="mb-0 small">Sem imagem</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold text-primary"><?php echo htmlspecialchars($campo->getNome()); ?></h4>
                            <?php if ($campo->getDescricao()): ?>
                                <p class="text-muted small mb-2"><?php echo htmlspecialchars(substr($campo->getDescricao(), 0, 80)) . (strlen($campo->getDescricao()) > 80 ? '...' : ''); ?></p>
                            <?php endif; ?>
                            <p class="text-muted mb-1">📞 <?php echo htmlspecialchars($campo->getTelefone()); ?></p>
                            <a href="#" class="btn btn-primary d-block mt-3 rounded-3"
                                data-bs-toggle="modal" data-bs-target="#<?php echo $campo->getId_campo(); ?>">Agendar</a>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="<?php echo $campo->getId_campo(); ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold text-primary">Agende com <?php echo htmlspecialchars($campo->getNome()); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="/agenda_futebol/controller/agendamento.php" method="POST">
                                <?php
                                $inicioAtendimento = $campo->getInicio_atendimento();
                                $fimAtendimento = $campo->getFim_atendimento();
                                ?>
                                <div class="modal-body">
                                    <?php if ($campo->getDescricao()): ?>
                                        <div class="alert alert-info mb-3">
                                            <strong>📝 Sobre o campo:</strong><br>
                                            <?php echo nl2br(htmlspecialchars($campo->getDescricao())); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <input type="hidden" name="id_campo" value="<?php echo $campo->getId_campo(); ?>">

                                    <label for="diaPartida">Agende o dia:</label>
                                    <input class="form-control mb-3" id="diaPartida" name="diaPartida" placeholder="Dia da partida" type="date">

                                    <label for="horarioInicioPartida">Horário de início (<?php echo $inicioAtendimento; ?> e <?php echo $fimAtendimento; ?>):</label>
                                    <input class="form-control mb-3"
                                        min="<?php echo $inicioAtendimento; ?>"
                                        max="<?php echo $fimAtendimento; ?>"
                                        step="1800"
                                        id="horarioInicioPartida"
                                        name="horarioInicioPartida"
                                        placeholder="Horário da partida"
                                        type="time">
                                    <label for="horarioFinalPartida">Horário final:</label>
                                    <input class="form-control mb-3"
                                        min="<?php echo $inicioAtendimento; ?>"
                                        max="<?php echo $fimAtendimento; ?>"
                                        step="1800"
                                        id="horarioFinalPartida"
                                        name="horarioFinalPartida"
                                        placeholder="Horário da partida"
                                        type="time">
                                </div>

                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary px-4">Agendar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona todos os campos de horário (início e fim)
            document.querySelectorAll('input[type="time"]').forEach(input => {
                input.addEventListener('change', function() {
                    const valor = this.value;

                    if (!valor) return;

                    const [hora, minuto] = valor.split(':').map(Number);

                    // Se não for :00 ou :30 → corrige automaticamente
                    if (minuto !== 0 && minuto !== 30) {
                        // Arredonda para o mais próximo
                        let minutosAjustados = (minuto < 15) ? 0 : (minuto < 45 ? 30 : 0);
                        let horaAjustada = (minuto >= 45) ? (hora + 1) % 24 : hora;

                        const horarioAjustado =
                            `${horaAjustada.toString().padStart(2, '0')}:${minutosAjustados.toString().padStart(2, '0')}`;

                        // Mostra alerta amigável
                        Swal.fire({
                            icon: 'warning',
                            title: 'Horário ajustado',
                            html: `Somente horários cheios ou de meia hora são permitidos.<br>
                           O horário foi ajustado automaticamente para <b>${horarioAjustado}</b>.`,
                            confirmButtonColor: '#0d6efd'
                        });

                        // Atualiza o valor do campo
                        this.value = horarioAjustado;
                    }
                });
            });
        });
    </script>

</body>

</html>