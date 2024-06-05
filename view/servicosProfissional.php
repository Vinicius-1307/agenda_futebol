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

    <h2 class="tituloHome mt-4 mb-4">Serviços</h2>
    
    <?php
        include_once('../model/Servicos.php');
        include_once('../model/Servico_profissional.php');

        $id_barbeiro = $_GET['id_prof'];
        $s = new Servicos();
        $servicos = $s->pegarServicosCompletosBarbeiro($id_barbeiro);

        foreach($servicos as $servico){
            $nomeServico = $servico->getNome_servico();
            $fotoServico = $servico->getFoto_servico();
            $precoServico = $servico->getPreco_servico();
            $html = <<<HTML
                <div class='card' style='width: 18rem;'>
                    <img src='$fotoServico' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>Servico: $nomeServico</h5>
                        <p class='card-text'>Preço: $precoServico</p>
                    </div>
                </div>
            HTML;
            echo $html;
        }

    ?>

    <div class="footer mt-5 p-4 text-white text-center">
        <p>Footer</p>
    </div>
</body>

</html>