function cancelarReserva(id_reserva) {
  $.ajax({
    url: "../controller/cancelarReserva.php",
    method: "POST",
    data: { id_reserva },
    success: function () {
      alert("Agendamento cancelado com sucesso!");

      setTimeout(function () {
        window.location.reload();
      }, 500);
    },
    error: function (xhr, status, error) {
      alert("Erro ao cancelar agendamento!");
    },
  });
}
