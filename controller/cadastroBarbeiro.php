<?php 

include_once '../model/barber.php';

$nome = $_POST['nome'];
$preço = $_POST['preco'];

$barber = new Barber();

$barber->setName($nome);
$barber->setHaircut_price($preço);

if($barber->createBarber()){
    header('Location: ../view/home.html');
}


?>