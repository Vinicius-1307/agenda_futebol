<?php
include_once '../model/Campos.php';
include_once '../model/Clientes.php';
include_once('../utils/alert.php');

session_start();

$cliente = new Clientes();

// Recebe dados do formulário
$nome = $_POST['nome'];
$inicio_operacao = $_POST['inicio_operacao'];
$fim_operacao = $_POST['fim_operacao'];
$id_cliente = $_SESSION['id_cliente'];
$preco_slot = $_POST['preco_slot'];

// Instancia os modelos
$campo = new Campos();

// Define os valores no modelo principal
$campo->setNome($nome);
$campo->setInicio_operacao($inicio_operacao);
$campo->setFim_operacao($fim_operacao);
$campo->setPreco_slot($preco_slot);
$campo->setId_cliente($id_cliente);

if ($campo->campoExiste()) {
    sweetAlert('Erro', 'Já existe um campo com esse nome para este cliente!', 'error', '/agenda_futebol/view/cadastroCampos.php');
    exit;
}

// Salva o campo no banco
if ($campo->createCampo()) {
    $id_campo = $campo->getId_campo();

    sweetAlert('Sucesso', 'Campo cadastrado com sucesso!', 'success', '/agenda_futebol/view/administrador.php');
} else {
    sweetAlert('Erro', 'Erro ao cadastrar o campo!', 'error', '/agenda_futebol/view/cadastroCampos.php');
}
