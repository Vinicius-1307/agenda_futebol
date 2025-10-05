// Máscaras de formulário
$(document).ready(function () {
  // Máscara de CPF: 000.000.000-00
  $("#cpf").mask("000.000.000-00");

  // Máscara de RG: 00.000.000-0 (formato mais comum)
  $("#rg").mask("00.000.000-0");

  // Máscara de telefone
  $("#telefone").mask("(00) 90000-0000");
});

function formatCpf($cpf) {
    // Remove tudo que não é número
    $cpf = preg_replace("/\D/", '', $cpf);
    // Formata: 000.000.000-00
    return preg_match('/(\d{3})(\d{3})(\d{3})(\d{2})/', $cpf, $matches) ? "{$matches[1]}.{$matches[2]}.{$matches[3]}-{$matches[4]}" : $cpf;
}

function formatRg($rg) {
    $rg = preg_replace("/\D/", '', $rg);
    // Formato comum: 00.000.000-0
    return preg_match('/(\d{2})(\d{3})(\d{3})(\d{1})/', $rg, $matches) ? "{$matches[1]}.{$matches[2]}.{$matches[3]}-{$matches[4]}" : $rg;
}

function formatTelefone($telefone) {
    $telefone = preg_replace("/\D/", '', $telefone);
    // Celular ou fixo
    if (strlen($telefone) === 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) === 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    } else {
        return $telefone;
    }
}