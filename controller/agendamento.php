<?php 

include_once '../model/Horarios.php';

$nome = $_POST['nome'];
$preço = $_POST['preco'];
$tempo = $_POST['minutos'];

$horario = new Horarios();

$barber->setName($nome);
$barber->setHaircut_price($preço);
$barber->setTime_haircut($tempo);

if($barber->createBarber()){
    header('Location: ../view/home.php');
}


?>