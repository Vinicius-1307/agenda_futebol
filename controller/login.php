<?php 

include_once('../model/user.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$clientes = new Clientes();

$admin = $clientes->login($email, $senha);
if($admin->getIs_admin() == 1){
    session_start();
    $_SESSION['admin'] = true;
    header('Location: ../view/administrador.html');
}else if($admin->getIs_admin() == 0){
    header('Location: ../view/home.php');
}else{
    header('Location: ../view/login.html');
}

?>