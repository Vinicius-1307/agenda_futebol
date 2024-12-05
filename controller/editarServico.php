<?php
session_start();
include_once '../model/Servicos.php';

$id_servico = $_GET['id_servico'];
$servico = new Servicos();

$servicoData = $servico->readServicos($id_servico);

$dadosParaRetorno = [
    'id_servico' => $servicoData->getId_servico(),
    'nome_servico' => $servicoData->getNome_servico(),
    'preco_servico' => $servicoData->getPreco_servico(),
    'foto_servico' => $servicoData->getFoto_servico(),
    'tempo_servico' => $servicoData->getTempo_servico()
];

header('Content-Type: application/json');
echo json_encode($dadosParaRetorno);

?>