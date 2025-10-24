function cancelarReserva(id_reserva) {
    if (confirm("Tem certeza que deseja cancelar esta reserva?")) {
        $.ajax({
            url: "../controller/cancelarReserva.php",
            method: "POST",
            data: { id_reserva },
            success: function (res) {
                sweetAlert('Sucesso', res, 'success', '../view/home.php');
                location.reload();
            },
            error: function () {
                sweetAlert('Erro', 'Erro ao cancelar reserva.', 'error', '../view/home.php');
            }
        });
    }
}
