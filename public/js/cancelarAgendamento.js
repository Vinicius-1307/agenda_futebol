function cancelarAgendamento(id_horario) {
    $.ajax({
        url: '../controller/cancelarAgendamento.php',
        type: 'POST',
        data: {
            id_horario: id_horario
        },
        success: function () {
            alert('Agendamento cancelado com sucesso!');
            
            setTimeout(function () {
                window.location.reload();
            }, 500);
        }, 
        error: function (xhr, status, error) {
            alert('Erro ao cancelar agendamento!');
        }
    });
}
