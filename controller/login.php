<?php 

include_once('../model/Clientes.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$clientes = new Clientes();

$login = $clientes->login($email, $senha);

if($login){
    header('Location: ../view/home.php');
}else{
    header('Location: ../view/login.html');
}

?>