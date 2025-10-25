<?php

include_once('../model/Clientes.php');
include_once('../utils/alert.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$clientes = new Clientes();

$login = $clientes->login($email, $senha);

session_start();

if ($login) {
    if ($login->getIs_admin() == 1) {
        $_SESSION['is_admin'] = 1;
        return header('Location: ../view/administrador.php');
    }

    $_SESSION['cpf'] = $login->getCpf();
    $_SESSION['nomeCliente'] = $login->getNome();
    return header('Location: ../view/home.php');
} else {
    sweetAlert('Erro', 'Usuário não encontrado!', 'error', '../view/login.html');
}
