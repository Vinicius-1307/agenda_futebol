<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../public/js/cancelarAgendamento.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Cardoso Barber</title>
</head>

<body>
    <div class="fundoNav p-4 text-center">
        <div class="top">
            <img src="../public/images/image.png" height="200px" width="400px" alt="">
        </div>
    </div>

    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/login.html">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="tituloHome mt-4 mb-4">Agendas Marcadas</h2>

    <?php
        session_start();
        require_once '../model/Agendas.php';
        require_once '../model/Servico_profissional.php';

        $agenda = new Agendas();
        $servicoProfissional = new Servico_profissional();
        $horariosUsuario = $agenda->agendaHorarioUsuario($_SESSION['cpf']);
    ?>

    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Cliente</th>
                    <th scope="col" class="text-center">Profissional</th>
                    <th scope="col" class="text-center">Serviço</th>
                    <th scope="col" class="text-center">Dia</th>
                    <th scope="col" class="text-center">Horário Início</th>
                    <th scope="col" class="text-center">Horário Fim (previsto)</th>
                    <th scope="col" class="text-center">Ação</th>
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
                        <td class="text-center"><button onclick="cancelarAgendamento(<?php echo $horario->getId_horario() ?>)" type="button" class="btn btn-outline-danger">Cancelar</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        <p></p>
    </div>
</body>

</html>