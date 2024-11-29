<?php 

include_once '../model/Profissionais.php';

$nome = $_POST['nome'];
$cpf = str_replace(['.', '-'], '', $_POST['cpf']);
$rg = str_replace(['.', '-'], '', $_POST['rg']);
$telefone = $_POST['telefone'];
$inicio_atendimento = $_POST['inicioAtendimento'];
$fim_atendimento = $_POST['fimAtendimento'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$ano = date('Y');

$profissional = new Profissionais();

$profissional->setNome($nome);
$profissional->setCpf($cpf);
$profissional->setRg($rg);
$profissional->setTelefone($telefone);
$profissional->setInicio_atendimento($inicio_atendimento);
$profissional->setFim_atendimento($fim_atendimento);
$profissional->setAno_cadastro($ano);
$profissional->setEmail($email);
$profissional->setSenha($senha);

if($profissional->createProfissionais()){
    echo <<<HTML
        <script>
            alert('Profissional cadastrado com sucesso!');
            window.location.href='../view/administrador.php';
        </script>
    HTML;}

?>