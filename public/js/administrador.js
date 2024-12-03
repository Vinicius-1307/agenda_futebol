function excluirProfissional(id_prof) {
    $.ajax({
        url: '../controller/excluirProfissional.php',
        type: 'POST',
        data: {
            id_prof: id_prof
        },
        success: function (response) {
            alert('Barbeiro excluído com sucesso!');
            
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }, 
        error: function (xhr, status, error) {
            alert('Erro ao excluir usuário!');
        }
    });
}
