<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                    <a class="nav-link" href="#">Cadastrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/login.html">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="tituloHome mt-4 mb-4">Agendar Horários</h2>

    <div class="container">
        <div class="row">
            <?php
            include_once('../model/Profissionais.php');
            $barber = new Profissionais();
            $barbeiros = $barber->readAll();
            $count = 0;
            foreach ($barbeiros as $barbeiro) :
                $name = $barbeiro->getNome();
                if ($count % 3 == 0) {
                    if ($count != 0) {
                        echo '</div><div class="row">';
                    }
                }
            ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?php echo $name; ?></h3>
                            <p class="card-text text-center font-size-sm">Telefone: <?php echo $barbeiro->getTelefone(); ?></p>
                            <p class="card-text text-center font-size-sm">Ano de cadastro: <?php echo $barbeiro->getAno_cadastro(); ?></p>
                            <a href="#" class="btn btn-primary d-grid" data-bs-toggle="modal" data-bs-target="#<?php echo $barbeiro->getId_prof(); ?>">Agendar</a>
                            <div class="modal fade" id="<?php echo $barbeiro->getId_prof(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agende com <?php echo $barbeiro->getNome(); ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../controller/agendamento.php">
                                            <div class="modal-body">
                                                <label for="diaCorte">Serviço:</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Selecione o Serviço</option>
                                                    <?php
                                                        include('../model/Servicos.php');
                                                        include('../model/Servico_profissional.php');
                                                        
                                                        $s = new Servicos();
                                                        $servicos = $s->pegarServicosBarbeiro($barbeiro->getId_prof());
                                                        foreach ($servicos as $servico){
                                                            $id_servico = $servico->getId_servico();
                                                            $nomeServico = $servico->getNome_servico();
                                                            echo "<option value='$id_servico'>$nomeServico</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <label for="diaCorte">Agende o dia:</label>
                                                <input class="form-control mb-3" id="diaCorte" placeholder="Dia do corte" type="date">
                                                <label for="horarioCorte">Agende seu horário:</label>
                                                <input class="form-control mb-3" id="horarioCorte" placeholder="Horário do corte" type="time">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Agendar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $count++;
            endforeach;
            ?>
        </div>

        <!-- <div class="card" style="width:400px">
            <img class="card-img-top" src="img_avatar1.png" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">John Doe</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div> -->

    </div>

    <div class="footer mt-5 p-4 text-white text-center">
        <p>Footer</p>
    </div>
</body>

</html>