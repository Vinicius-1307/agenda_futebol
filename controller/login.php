<?php 

include_once('../model/Clientes.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$clientes = new Clientes();

$login = $clientes->login($email, $senha);

if($login){
    session_start();
    $_SESSION['cpf'] = $login->getCpf();
    header('Location: ../view/home.php');
}else{
    echo <<<HTML
        <script>
            alert('Erro ao realizar agendamento!');
            window.location.href='../view/login.html';
        </script>
    HTML;
}

?>