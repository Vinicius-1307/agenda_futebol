<?php

if (isset($_SESSION['sucesso'])) {
    $msg = $_SESSION['sucesso'];
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '$msg',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>";
    unset($_SESSION['sucesso']);
}

if (isset($_SESSION['erros'])) {
    $erros = implode('\\n', $_SESSION['erros']); // junta os erros em linhas
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '$erros',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tentar novamente'
        });
    </script>";
    unset($_SESSION['erros']);
}
