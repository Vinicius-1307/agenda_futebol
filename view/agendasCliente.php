<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Agendas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery e JS custom -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/cancelarAgendamento.js"></script>

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
                        <a class="nav-link fw-semibold" href="./home.php">Home</a>
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
        <h2 class="tituloHome fw-bold text-center mb-5">Agendas Marcadas</h2>

        <?php
        session_start();
        require_once '../model/Agendas.php';
        require_once '../model/Servico_profissional.php';

        $agenda = new Agendas();
        $servicoProfissional = new Servico_profissional();
        $cpf = $_SESSION['cpf'] ?? null;
        $horariosUsuario = $agenda->agendaHorarioUsuario($cpf);
        ?>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Profissional</th>
                                <th class="text-center">Serviço</th>
                                <th class="text-center">Dia</th>
                                <th class="text-center">Início</th>
                                <th class="text-center">Fim (previsto)</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($horariosUsuario as $index => $horario) : ?>
                                <?php $dadosServicoProfissional = $servicoProfissional->pegarProfissionalServico($horario->getId_servico_prof()) ?>
                                <tr>
                                    <td class="text-center"><?php echo $_SESSION['nomeCliente'] ?></td>
                                    <td class="text-center"><?php echo $dadosServicoProfissional->getProfissional() ?></td>
                                    <td class="text-center"><?php echo $dadosServicoProfissional->getServico() ?></td>
                                    <td class="text-center">
                                        <?php
                                        $data = DateTime::createFromFormat('Y-m-d', $horario->getDia_semana());
                                        echo $data ? $data->format('d/m/Y') : '';
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $horario->getHorario_inicio() ?></td>
                                    <td class="text-center"><?php echo $horario->getHorario_fim() ?></td>
                                    <td class="text-center">
                                        <button onclick="cancelarAgendamento(<?php echo $horario->getId_horario() ?>)"
                                            type="button" class="btn btn-outline-danger btn-sm px-3 rounded-3">
                                            Cancelar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
</body>

</html>