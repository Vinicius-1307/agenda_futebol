<?php 

include_once '../model/barber.php';

$nome = $_POST['nome'];
$preço = $_POST['preco'];
$tempo = $_POST['minutos'];

$profissional = new Profissionais();

$profissional->setNome($nome);
// $profissional->setHaircut_price($preço);
// $profissional->setTime_haircut($tempo);

if($profissional->createProfissionais()){
    header('Location: ../view/home.php');
}


?>