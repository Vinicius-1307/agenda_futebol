<?php 

include_once '../model/Servicos.php';

$nomeServico = $_POST['nomeServico'];
$preco = $_POST['preco'];

$servico = new Servicos();

$servico->setNome_servico($nomeServico);
$servico->setPreco_servico($preco);

if($servico->createServicos()){
    header('Location: ../view/home.php');
}else{
    header('Location: ../view/cadastroBarbeiro.html');
}

?>