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
    <script src="/agenda_futebol/public/js/cancelarReserva.js"></script>

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
        require_once '../model/Reservas.php';

        $reservas = new Reservas();
        $id_cliente = $_SESSION['id_cliente'] ?? null;

        if (!$id_cliente) {
            header("Location: ../view/login.html");
            exit;
        }

        $listaReservas = $reservas->getReservasByCliente($id_cliente);
        ?>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Campo</th>
                                <th class="text-center">Dia</th>
                                <th class="text-center">Início</th>
                                <th class="text-center">Fim (previsto)</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($listaReservas)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Nenhuma reserva encontrada.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($listaReservas as $reserva): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $_SESSION['nomeCliente'] ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($reserva['nome_campo']) ?></td>
                                        <td class="text-center">
                                            <?php echo date('d/m/Y', strtotime($reserva['data_reserva'])) ?>
                                        </td>
                                        <td class="text-center"><?php echo $reserva['hora_inicio'] ?></td>
                                        <td class="text-center"><?php echo $reserva['hora_fim'] ?></td>
                                        <td class="text-center">R$ <?php echo number_format($reserva['valor_total'], 2, ',', '.') ?></td>
                                        <td class="text-center">
                                            <button onclick="cancelarReserva(<?php echo $reserva['id_reserva'] ?>)"
                                                type="button" class="btn btn-outline-danger btn-sm px-3 rounded-3">
                                                Cancelar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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