<?php

$id_horario = $_POST['id_horario'];

require_once '../model/Agendas.php';
require_once '../model/Horarios.php';

$agenda = new Agendas();
$horario = new Horarios();

$agenda->setId_horario($id_horario);
$agenda->deleteAgendaIdHorario();

$horario->setId_horario($id_horario);
$horario->deleteHorarios();

?>