<?php 

include_once '../model/Horarios.php';
include_once '../model/Servicos.php';
include_once '../model/Profissionais.php';
include_once '../model/Servico_profissional.php';

$horario = new Horarios();
$servico_profissional = new Servico_profissional();

$servico = $_POST['servico'];
$dia = $_POST['diaCorte'];
$horariosCorte = $_POST['horarioCorte'];
$id_prof = $_POST['id_prof'];

$tempoServico = $servico_profissional->pegarTempoServico($id_prof)->getTempo_servico();
$horario_inicio = $horariosCorte;
$horario_fim = $horario_inicio + $tempoServico;


// if($barber->createBarber()){
//     header('Location: ../view/home.php');
// }


?>