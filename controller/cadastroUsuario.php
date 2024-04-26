<?php 

include_once '../model/user.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$user = new User();

$user->setName($nome);
$user->setEmail($email);
$user->setPassword($senha);
$user->setIs_admin(0);

if($user->createUser()){
    header('Location: ../view/home.php');
}else{
    header('Location: ../view/cadastroBarbeiro.html');
}

?>