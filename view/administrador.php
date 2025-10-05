<?php
function formatCpf($cpf)
{
    $cpf = preg_replace("/\D/", '', $cpf); // Remove tudo que não é número
    if (preg_match('/(\d{3})(\d{3})(\d{3})(\d{2})/', $cpf, $matches)) {
        return "{$matches[1]}.{$matches[2]}.{$matches[3]}-{$matches[4]}";
    }
    return $cpf;
}

function formatRg($rg)
{
    $rg = preg_replace("/\D/", '', $rg);
    if (preg_match('/(\d{2})(\d{3})(\d{3})(\d{1})/', $rg, $matches)) {
        return "{$matches[1]}.{$matches[2]}.{$matches[3]}-{$matches[4]}";
    }
    return $rg;
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
                        <a class="nav-link fw-semibold" href="../view/cadastroCampos.php">Cadastrar Campos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="../view/servicosAdm.php">Campos</a>
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
        <h2 class="tituloHome fw-bold text-center mb-5">Proprietários Cadastrados</h2>

        <?php
        require_once '../model/Proprietarios.php';

        $proprietario = new Proprietarios();
        $proprietarios = $proprietario->readAll();
        ?>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center">Proprietário</th>
                                <th class="text-center">CPF</th>
                                <th class="text-center">RG</th>
                                <th class="text-center">Telefone</th>
                                <th class="text-center">E-mail</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proprietarios as $index => $proprietario) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $proprietario->getNome(); ?></td>
                                    <td class="text-center"><?php echo formatCpf($proprietario->getCpf()); ?></td>
                                    <td class="text-center"><?php echo formatRg($proprietario->getRg()); ?></td>
                                    <td class="text-center"><?php echo formatTelefone($proprietario->getTelefone()); ?></td>
                                    <td class="text-center"><?php echo $proprietario->getEmail(); ?></td>
                                    <td class="text-center">
                                        <button onclick="editarProprietario(<?php echo $proprietario->getId_prof(); ?>)"
                                            type="button" class="btn btn-primary btn-sm px-3 rounded-3">
                                            Editar
                                        </button>
                                        <button onclick="excluirProprietario(<?php echo $proprietario->getId_prof(); ?>)"
                                            type="button" class="btn btn-outline-danger btn-sm px-3 rounded-3">
                                            Excluir
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