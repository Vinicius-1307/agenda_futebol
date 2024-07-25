<?php 

include_once '../model/Horarios.php';
include_once '../model/Servicos.php';
include_once '../model/Profissionais.php';
include_once '../model/Servico_profissional.php';
include_once '../model/Agendas.php';

session_start();

$timezone = new DateTimeZone('America/Sao_Paulo');
$horario = new Horarios();
$agenda = new Agendas();
$servico_profissional = new Servico_profissional();

$servico = $_POST['servico'];
$dia = $_POST['diaCorte'];
$horariosCorte = $_POST['horarioCorte'];
$id_prof = $_POST['id_prof'];

$tempoServico = $servico_profissional->pegarTempoServico($id_prof)->getTempo_servico();

$data_inicio = new DateTime($dia . ' ' . $horariosCorte, $timezone);

list($hours, $minutes, $seconds) = explode(':', $tempoServico);
$tempoServicoInterval = new DateInterval(sprintf('PT%sH%sM%sS', $hours, $minutes, $seconds));

$data_fim = clone $data_inicio;
$data_fim->add($tempoServicoInterval)->format('H:i:s');

$horario->setHorario_fim($data_fim->format('H:i:s'));
$horario->setHorario_inicio($data_inicio->format('H:i:s'));
$horario->setDia_semana($dia);

$agenda->setId_servico_prof($servico_profissional->getId_servico_prof());
$agenda->setCpf_cliente($_SESSION['cpf']);

$horario->createHorarios();
$agenda->setId_horario($horario->getId_horario());


if($agenda->createAgendas()){
    echo <<<HTML
    <script>
        alert('Agendamento realizado com sucesso!');
        window.location.href='../view/home.php';
    </script>
HTML;
}else{
    echo <<<HTML
        <script>
            alert('Erro ao realizar agendamento!');
            window.location.href='../view/home.php';
        </script>
    HTML;
}


?>