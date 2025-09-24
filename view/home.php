<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                        <a class="nav-link fw-semibold" href="../view/login.html">Sair</a>
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
            include_once __DIR__ . '/../model/Profissionais.php';
            $barber = new Profissionais();
            $barbeiros = $barber->readAll();
            foreach ($barbeiros as $barbeiro) :
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 hover-card">
                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold text-primary"><?php echo $barbeiro->getNome(); ?></h4>
                            <p class="text-muted mb-1">📞 <?php echo $barbeiro->getTelefone(); ?></p>
                            <p class="text-muted">📅 Desde <?php echo $barbeiro->getAno_cadastro(); ?></p>
                            <a href="#" class="btn btn-primary d-block mt-3 rounded-3"
                                data-bs-toggle="modal" data-bs-target="#<?php echo $barbeiro->getId_prof(); ?>">Agendar</a>
                            <a href="./servicosProfissional.php?id_prof=<?php echo $barbeiro->getId_prof(); ?>"
                                class="btn btn-outline-success d-block mt-2 rounded-3">Serviços</a>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="<?php echo $barbeiro->getId_prof(); ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold text-primary">Agende com <?php echo $barbeiro->getNome(); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="../controller/agendamento.php" method="POST">
                                <div class="modal-body">
                                    <label class="fw-semibold mb-1">Serviço:</label>
                                    <select class="form-select mb-3" name="servico" required>
                                        <option selected disabled>Selecione o Serviço</option>
                                        <?php
                                        include_once('../model/Servicos.php');
                                        include_once('../model/Servico_profissional.php');
                                        $s = new Servicos();
                                        $servicos = $s->pegarServicosBarbeiro($barbeiro->getId_prof());
                                        $inicioAtendimento = $barbeiro->getInicio_atendimento();
                                        $fimAtendimento = $barbeiro->getFim_atendimento();
                                        foreach ($servicos as $servico) {
                                            $id_servico = $servico->getId_servico();
                                            $nomeServico = $servico->getNome_servico();
                                            echo "<option value='$id_servico'>$nomeServico</option>";
                                        }
                                        ?>
                                    </select>

                                    <label class="fw-semibold mb-1">Agende o dia:</label>
                                    <input class="form-control mb-3" type="date" name="diaCorte" required>

                                    <label class="fw-semibold mb-1">
                                        Horário (<?php echo $inicioAtendimento; ?> - <?php echo $fimAtendimento; ?>):
                                    </label>
                                    <input class="form-control mb-3" type="time"
                                        min="<?php echo $inicioAtendimento; ?>" max="<?php echo $fimAtendimento; ?>"
                                        name="horarioCorte" required>
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