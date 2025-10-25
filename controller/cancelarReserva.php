<?php
require_once '../model/Database.php';

$banco = new BancoAgendaFutebol();
$conn = $banco->getConexao();

if (isset($_POST['id_reserva'])) {
    $id = intval($_POST['id_reserva']);

    // Exclui o registro diretamente
    $stmt = $conn->prepare("DELETE FROM reservas WHERE id_reserva = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Reserva excluída com sucesso!";
    } else {
        echo "Erro ao excluir reserva.";
    }

    $stmt->close();
}

$conn->close();
