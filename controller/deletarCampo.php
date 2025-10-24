<?php
include_once '../model/Campos.php';
include_once '../utils/alert.php';

session_start();

if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../view/login.html');
    exit;
}

if (isset($_GET['id'])) {
    $id_campo = intval($_GET['id']);
    $campo = new Campos();

    $resultado = $campo->deleteCampo($id_campo);

    if ($resultado === true) {
        sweetAlert('Sucesso', 'Campo deletado com sucesso!', 'success', '../view/meusCampos.php');
    } elseif ($resultado === 'has_reservations') {
        sweetAlert('Aviso', 'Não é possível deletar este campo, pois ele possui horários reservados.', 'warning', '../view/meusCampos.php');
    } else {
        sweetAlert('Erro', 'Erro ao tentar deletar o campo.', 'error', '../view/meusCampos.php');
    }
} else {
    sweetAlert('Aviso', 'Nenhum campo selecionado.', 'warning', '../view/meusCampos.php');
}
