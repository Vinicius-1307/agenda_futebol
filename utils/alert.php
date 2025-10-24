<?php
function sweetAlert($title, $message, $icon = 'info', $redirect = null) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>$title</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "$title",
                    text: "$message",
                    icon: "$icon",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "$redirect";
                });
            });
        </script>
    </body>
    </html>
    HTML;
    exit;
}
?>
