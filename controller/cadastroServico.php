<?php 

include_once '../model/Servicos.php';
include_once '../model/Servico_profissional.php';
include_once '../model/Fotos_servicos.php';

$nomeServico = $_POST['nomeServico'];
$preco = $_POST['preco'];
$tempo = $_POST['tempo'];
$idProfissional = $_POST['profissional'];

$servico = new Servicos();
$servicoProfissional = new Servico_profissional();
$fotosServicos = new Fotos_servicos();

$servico->setNome_servico($nomeServico);
$servico->setPreco_servico($preco);

if ($servico->createServicos()) {
    $id_servico = $servico->getId_servico();
    $servicoProfissional->setId_servico($id_servico);
    $servicoProfissional->setTempo_servico($tempo);
    $servicoProfissional->setPreco_servico($preco);
    $servicoProfissional->setId_prof($idProfissional);

    if ($servicoProfissional->createServico_profissional()) {
        $fotosServicos->setId_servico($id_servico);

        foreach ($_FILES['fotos']['name'] as $key => $name) {
            if ($_FILES['fotos']['error'][$key] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['fotos']['tmp_name'][$key];
                $upload_dir = '../uploads/img/';
                $upload_file = $upload_dir . basename($name);
                
                if (move_uploaded_file($tmp_name, $upload_file)) {
                    $fotosServicos->setNome_arquivo($upload_file);
                    $fotosServicos->createFotos_servicos();
                }
            }
        }

        echo <<<HTML
            <script>
                alert('Serviço cadastrado!');
                window.location.href='../view/administrador.php';
            </script>
        HTML;

    } else {
        echo <<<HTML
            <script>
                alert('Erro ao criar serviço!');
                window.location.href='../view/cadastroServico.php';
            </script>
        HTML;
    }
} else {
    echo <<<HTML
        <script>
            alert('Erro ao criar serviço!');
            window.location.href='../view/cadastroServico.php';
        </script>
    HTML;
}

?>
