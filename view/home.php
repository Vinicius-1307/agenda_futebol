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
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold text-primary"><?php echo $campo->getNome(); ?></h4>
                            <p class="text-muted mb-1">📞 <?php echo $campo->getTelefone(); ?></p>
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
                                <h5 class="modal-title fw-bold text-primary">Agende com <?php echo $campo->getNome(); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="/agenda_futebol/controller/agendamento.php" method="POST">
                                <?php
                                $inicioAtendimento = $campo->getInicio_atendimento();
                                $fimAtendimento = $campo->getFim_atendimento();
                                ?>
                                <div class="modal-body">
                                    <input type="hidden" name="id_campo" value="<?php echo $campo->getId_campo(); ?>">

                                    <label for="diaPartida">Agende o dia:</label>
                                    <input class="form-control mb-3" id="diaPartida" name="diaPartida" placeholder="Dia da partida" type="date">
                                    <label for="horarioPartida">Agende seu horário entre (<?php echo $inicioAtendimento; ?> e <?php echo $fimAtendimento; ?>):</label>
                                    <input class="form-control mb-3" min='<?php echo $inicioAtendimento; ?>' max='<?php echo $fimAtendimento; ?>' id="horarioPartida" name="horarioPartida" placeholder="Horário da partida" type="time">
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
</body>

</html>