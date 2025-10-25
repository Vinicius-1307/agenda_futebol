// Máscaras de formulário
$(document).ready(function () {
  // Máscara de CPF: 000.000.000-00
  $("#cpf").mask("000.000.000-00");

  // Máscara de RG: 00.000.000-0 (formato mais comum)
  $("#rg").mask("00.000.000-0");

  // Máscara de telefone
  $("#telefone").mask("(00) 90000-0000");
});

function formatCpf(cpf) {
  // Remove tudo que não é número
  cpf = cpf.replace(/\D/g, "");
  // Formata: 000.000.000-00
  return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
}

function formatRg(rg) {
  rg = rg.replace(/\D/g, "");
  // Formato comum: 00.000.000-0
  return rg.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");
}

function formatTelefone(telefone) {
  telefone = telefone.replace(/\D/g, "");
  if (telefone.length === 11) {
    return telefone.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
  } else if (telefone.length === 10) {
    return telefone.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
  } else {
    return telefone;
  }
}
