<?php
include_once '../model/Campos.php';
include_once('../utils/alert.php');

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../view/login.html');
    exit;
}

// Recebe dados do formulário
$id_campo = $_POST['id_campo'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'] ?? null;
$inicio_operacao = $_POST['inicio_operacao'];
$fim_operacao = $_POST['fim_operacao'];
$id_cliente = $_SESSION['id_cliente'];
$preco_slot = $_POST['preco_slot'];
$imagem_atual = $_POST['imagem_atual'] ?? null;

// Processar upload da nova imagem (se houver)
$imagem = $imagem_atual; // Mantém a imagem atual por padrão

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $diretorio_upload = '../public/images/campos/';
    
    // Criar diretório se não existir
    if (!is_dir($diretorio_upload)) {
        mkdir($diretorio_upload, 0777, true);
    }
    
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid() . '_' . time() . '.' . $extensao;
    $caminho_completo = $diretorio_upload . $nome_arquivo;
    
    // Validar tipo de arquivo (apenas imagens)
    $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array(strtolower($extensao), $tipos_permitidos)) {
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
            // Se tinha imagem antiga, remove do servidor
            if ($imagem_atual && file_exists('../public/images/' . $imagem_atual)) {
                unlink('../public/images/' . $imagem_atual);
            }
            $imagem = 'campos/' . $nome_arquivo;
        }
    }
}

// Instancia o modelo
$campo = new Campos();

// Verifica se o campo pertence ao usuário logado
$campoExistente = $campo->getById($id_campo);
if (!$campoExistente || $campoExistente->getId_cliente() != $id_cliente) {
    sweetAlert('Erro', 'Você não tem permissão para editar este campo!', 'error', '/agenda_futebol/view/meusCampos.php');
    exit;
}

// Define os valores no modelo
$campo->setId_campo($id_campo);
$campo->setNome($nome);
$campo->setDescricao($descricao);
$campo->setImagem($imagem);
$campo->setInicio_operacao($inicio_operacao);
$campo->setFim_operacao($fim_operacao);
$campo->setPreco_slot($preco_slot);
$campo->setId_cliente($id_cliente);

// Atualiza o campo no banco
if ($campo->updateCampo()) {
    sweetAlert('Sucesso', 'Campo atualizado com sucesso!', 'success', '/agenda_futebol/view/meusCampos.php');
} else {
    sweetAlert('Erro', 'Erro ao atualizar o campo!', 'error', '/agenda_futebol/view/editarCampo.php?id=' . $id_campo);
}
