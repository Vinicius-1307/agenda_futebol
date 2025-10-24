<?php 

include_once('../model/Clientes.php');
include_once('../model/Profissionais.php');
include_once('../utils/alert.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$clientes = new Clientes();
$profissional = new Profissionais();

$login = $clientes->login($email, $senha);
$loginBarbeiro = $profissional->login($email, $senha);

session_start();

if($login){
    if($login->getIs_admin() == 1){
        $_SESSION['is_admin'] = 1;
        return header('Location: ../view/administrador.php');
    }

    $_SESSION['cpf'] = $login->getCpf();
    $_SESSION['nomeCliente'] = $login->getNome();
    return header('Location: ../view/home.php');

} else if($loginBarbeiro){
    $_SESSION['is_admin'] = 0;
    $_SESSION['id_prof'] = $loginBarbeiro->getId_prof();
    $_SESSION['nomeBarbeiro'] = $loginBarbeiro->getNome();

    return header('Location: ../view/agendasBarbeiro.php');

} else{
    sweetAlert('Erro', 'Usuário não encontrado!', 'error', '../view/login.html');
}
?>