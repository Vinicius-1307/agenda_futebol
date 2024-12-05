<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../public/js/editarServico.js"></script>
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
                    <a class="nav-link" href="../view/agendasBarbeiro.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/cadastroServico.php">Cadastrar Serviço</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/login.html">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="tituloHome mt-4 mb-4">Serviços</h2>
    
    <?php
        session_start();
        include_once('../model/Servicos.php');
        include_once('../model/Servico_profissional.php');

        $s = new Servicos();
        $servicos = $s->pegarServicosCompletosBarbeiro($_SESSION['id_prof']);

        echo "<div class='container'>";
        echo "<div class='row'>";

        $counter = 0;
        foreach($servicos as $servico){
            $idServico = $servico->getId_servico();
            $nomeServico = $servico->getNome_servico();
            $fotoServico = $servico->getFoto_servico();
            $precoServico = $servico->getPreco_servico();
            
            $tempoServico = DateTime::createFromFormat('H:i:s', $servico->getTempo_servico());
            $tempoFormatado = $tempoServico ? $tempoServico->format('H:i:s') : '00:00:00';
            
            $caminhoImagem = '../uploads/img/sem-imagem.jpg';
            if ($fotoServico && file_exists($fotoServico)) {
                $caminhoImagem = $fotoServico;
            }
            
            $html = <<<HTML
                <div class='col-md-4 d-flex mb-4'>
                    <div class='card w-100'>
                        <img src='$caminhoImagem' class='card-img-top' alt='...' style='height: 250px; object-fit: cover;'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title'>Serviço: $nomeServico</h5>
                            <p class='card-text mb-1'>Preço: R$$precoServico</p>
                            <p class='card-text'>Tempo serviço: $tempoFormatado</p>
                            <button type="button" onclick="editarServico($idServico)" class="btn btn-outline-primary">Editar</button>
                        </div>
                    </div>
                </div>
            HTML;
            
            echo $html;

            $counter++;
            if ($counter % 3 == 0) {
                echo "</div><div class='row'>"; 
            }
        }
        echo "</div>"; 
        echo "</div>"; 
    ?>

    <div class="footer mt-5 p-4 text-white text-center">
        <p></p>
    </div>
</body>

</html>