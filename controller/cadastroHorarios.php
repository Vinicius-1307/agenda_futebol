<?php

include_once('../model/schedules.php');

$horaInicial = $_POST['horaInicial'];
$horaFinal = $_POST['horaFinal'];

$schedule = new Schedules();

$schedule->setInitial_hour($horaInicial);
$schedule->setFinal_hour($horaFinal);

if($schedule->createSchedules()){
    header('Location: ../view/administrador.html');
}

?>