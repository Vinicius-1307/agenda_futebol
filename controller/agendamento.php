<?php 

include_once '../model/barber.php';

$nome = $_POST['nome'];
$preço = $_POST['preco'];
$tempo = $_POST['minutos'];

$hotario = new Horarios();

$barber->setName($nome);
$barber->setHaircut_price($preço);
$barber->setTime_haircut($tempo);

if($barber->createBarber()){
    header('Location: ../view/home.php');
}


?>