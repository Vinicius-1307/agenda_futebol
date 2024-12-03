<?php 

include_once '../model/Servico_profissional.php';
include_once '../model/Agendas.php';
include_once '../model/Profissionais.php';

$servico_profissional = new Servico_profissional();
$agenda = new Agendas();
$profissional = new Profissionais();

$id_prof = $_POST['id_prof'];

$ids_servico_profissional = $servico_profissional->pegarServicosProfissional($id_prof);

if(count($ids_servico_profissional) >= 1){
    $agenda->deleteAgendasArray($ids_servico_profissional);
    $servico_profissional->deleteServico_profissional($ids_servico_profissional);
}

$profissional->setId_prof($id_prof);
$profissional->deleteProfissionais();

?>