<?php
session_start();
include_once '../model/Servicos.php';
include_once '../model/Servico_profissional.php';
include_once '../model/Fotos_servicos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servico = $_POST['id_servico'];
    $nomeServico = $_POST['nomeServico'];
    $preco = $_POST['preco'];
    $tempo = $_POST['tempo'];

    $servico = new Servicos();
    $servicoProfissional = new Servico_profissional();
    $fotosServicos = new Fotos_servicos();

    $servico->setId_servico($id_servico);
    $servico->setNome_servico($nomeServico);

    $servicoProfissional->setId_servico($id_servico);
    $servicoProfissional->setPreco_servico($preco);
    $servicoProfissional->setTempo_servico($tempo);

    if($servico->updateServicos()){
        if($servicoProfissional->updateServico_profissional()){
            
            $existeFotoServico = $fotosServicos->existeFotoServico($id_servico);

            foreach ($_FILES['fotos']['name'] as $key => $name) {
                if ($_FILES['fotos']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['fotos']['tmp_name'][$key];
                    $upload_dir = '../uploads/img/';
                    
                    
                    $file_extension = pathinfo($name, PATHINFO_EXTENSION);
                    $unique_filename = uniqid('SERVICO_') . '.' . $file_extension;
                    $upload_file = $upload_dir . $unique_filename;
                    
                    if (move_uploaded_file($tmp_name, $upload_file)) {
                        $fotosServicos->setNome_arquivo($upload_file);
                        $fotosServicos->setId_servico($id_servico);
                        
                        if ($existeFotoServico) {
                            $fotosServicos->updateFotos_servicos();
                        } else {
                            $fotosServicos->createFotos_servicos();
                        }
                    }
                }
            }

            if($_SESSION['is_admin'] == 1){
                echo <<<HTML
                    <script>
                        alert('Serviço editado!');
                        window.location.href='../view/servicosAdm.php';
                    </script>
                HTML;
            } else {
                echo <<<HTML
                    <script>
                        alert('Serviço editado!');
                        window.location.href='../view/servicosBarbeiro.php';
                    </script>
                HTML;
            }
        }
    } else {
        if($_SESSION['is_admin'] == 1){
            echo <<<HTML
                <script>
                    alert('Erro ao Editar Serviço!');
                    window.location.href='../view/servicosAdm.php';
                </script>
            HTML;
        } else {
            echo <<<HTML
                <script>
                    alert('Erro ao Editar Serviço!');
                    window.location.href='../view/servicosBarbeiro.php';
                </script>
            HTML;
        }
    }
}
?>
