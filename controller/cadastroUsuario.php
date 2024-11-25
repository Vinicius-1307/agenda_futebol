<?php 

include_once '../model/Clientes.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$cpf = str_replace(['.', '-'], '', $_POST['cpf']);

$cliente = new Clientes();

$cliente->setNome($nome);
$cliente->setEmail($email);
$cliente->setSenha($senha);
$cliente->setTelefone($telefone);
$cliente->setCpf($cpf);
$cliente->setIs_admin(0);

if($cliente->createClientes()){
    session_start();
    $_SESSION['cpf'] = $cliente->getCpf();
    header('Location: ../view/home.php');
}else{
    header('Location: ../view/cadastroBarbeiro.html');
}

?>