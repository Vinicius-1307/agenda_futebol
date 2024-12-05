function editarServico(id_servico) {
    $.ajax({
        url: '../controller/editarServico.php',
        type: 'GET',
        data: {
            id_servico: id_servico
        },
        success: function (response) {
            window.location.href = '../view/formularioEdicaoServico.php?' + 
                'id_servico=' + response.id_servico + 
                '&nome_servico=' + response.nome_servico + 
                '&preco_servico=' + response.preco_servico + 
                '&foto_servico=' + response.foto_servico + 
                '&tempo_servico=' + response.tempo_servico
        }, 
        error: function (xhr, status, error) {
            alert('Erro ao buscar dados do serviço!');
        }
    });
}