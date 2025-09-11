<?php
require_once '../model/Proprietario.php';

/**
 * Função para limpar os campos numéricos
 */
function limparCampo($value)
{
    return preg_replace('/\D/', '', $value);
}

// --- Captura e validação dos dados ---
$nome       = $_POST['nome'] ?? null;
$cpf        = isset($_POST['cpf']) ? limparCampo($_POST['cpf']) : null;
$rg         = isset($_POST['rg']) ? limparCampo($_POST['rg']) : null;
$telefone   = $_POST['telefone'] ?? null;
$email      = $_POST['email'] ?? null;
$senha      = $_POST['senha'] ?? null;
$ano        = date('Y');

// --- Validação básica ---
$erros = [];
if (!$nome) $erros[] = "Nome é obrigatório.";
if (!$cpf) $erros[] = "CPF é obrigatório.";
if (!$email) $erros[] = "Email é obrigatório.";
if (!$senha) $erros[] = "Senha é obrigatória.";

session_start();

if (!empty($erros)) {
    $_SESSION['erros'] = $erros;
    header("Location: ../view/cadastroProprietario.php");
    exit;
}

// --- Montagem do objeto ---
$proprietario = new Proprietario();
$proprietario->setNome($nome);
$proprietario->setCpf($cpf);
$proprietario->setRg($rg);
$proprietario->setTelefone($telefone);
$proprietario->setAno_cadastro($ano);
$proprietario->setEmail($email);
$proprietario->setSenha($senha);

// --- Persistência ---
if ($proprietario->createProprietario()) {
    $_SESSION['sucesso'] = "Proprietário cadastrado com sucesso!";
    header("Location: ../view/cadastroProprietario.php");
    exit;
} else {
    $_SESSION['erros'] = ["Erro ao cadastrar proprietário."];
    header("Location: ../view/cadastroProprietario.php");
    exit;
}
