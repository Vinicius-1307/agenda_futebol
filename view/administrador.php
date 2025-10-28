<?php
session_start();
require_once '../model/Reservas.php';
require_once '../utils/alert.php'; // se quiser usar sweetAlert

// 🔒 Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    sweetAlert('Acesso negado', 'Você precisa fazer login para acessar esta página.', 'error', '../view/login.html');
    exit;
}

// 🔒 Verifica se o usuário é administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    sweetAlert('Acesso restrito', 'Apenas administradores podem acessar esta página.', 'warning', '../view/home.php');
    exit;
}

// =====================
// Funções auxiliares
// =====================
function formatCpf($cpf)
{
    $cpf = preg_replace("/\D/", '', $cpf);
    if (preg_match('/(\d{3})(\d{3})(\d{3})(\d{2})/', $cpf, $matches)) {
        return "{$matches[1]}.{$matches[2]}.{$matches[3]}-{$matches[4]}";
    }
    return $cpf;
}

function formatTelefone($telefone)
{
    $telefone = preg_replace("/\D/", '', $telefone);
    if (strlen($telefone) === 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) === 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }
    return $telefone;
}

function formatarData($data)
{
    return date('d/m/Y', strtotime($data));
}

function formatarHora($hora)
{
    return date('H:i', strtotime($hora));
}

// =====================
// Busca de reservas
// =====================
$reservasModel = new Reservas();
$id_cliente = $_SESSION['id_cliente'];
$reservas = $reservasModel->getReservasByProprietario($id_cliente);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutAgenda - Administração</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery e JS custom -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/administrador.js"></script>

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
                        <a class="nav-link fw-semibold" href="../view/meusCampos.php">Meus Campos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/cadastroCampos.php">Cadastrar Campos</a>
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
        <h2 class="tituloHome fw-bold text-center mb-5">Horários Marcados</h2>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <?php if (count($reservas) === 0): ?>
                    <div class="alert alert-warning text-center m-0">Nenhuma reserva encontrada para seus campos.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Campo</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservas as $r): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($r['nome_campo']) ?></td>
                                        <td><?= htmlspecialchars($r['nome_cliente']) ?></td>
                                        <td><?= formatarData($r['data_reserva']) ?></td>
                                        <td><?= formatarHora($r['hora_inicio']) ?></td>
                                        <td><?= formatarHora($r['hora_fim']) ?></td>
                                        <td>R$ <?= number_format($r['valor_total'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        © 2025 FutAgenda - Todos os direitos reservados
    </footer>
</body>

</html>