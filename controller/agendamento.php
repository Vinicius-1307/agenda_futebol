<?php
include_once '../model/Reservas.php';
include_once '../model/Campos.php';
include_once '../model/Clientes.php';
include_once('../utils/alert.php');

session_start();

date_default_timezone_set('America/Sao_Paulo');

$campoModel = new Campos();
$reservaModel = new Reservas();

// Recebe os dados do formulário
$id_campo = $_POST['id_campo'];
$diaPartida = $_POST['diaPartida'];
$horarioPartida = $_POST['horarioPartida'];

$dataHoje = new DateTime('today');
$dataSelecionada = new DateTime($diaPartida);

if ($dataSelecionada < $dataHoje) {
    sweetAlert('Erro', 'A data selecionada já passou. Por favor, escolha uma data válida.', 'error', '../view/home.php');
}

// Busca informações do campo
$campo = $campoModel->getById($id_campo);
if (!$campo) {
    sweetAlert('Erro', 'Campo não encontrado!', 'error', '../view/home.php');
    exit;
}

// Pegando dados do campo
$inicio_operacao = $campo->getInicio_atendimento();
$fim_operacao = $campo->getFim_atendimento();
$duracao_slot = $campo->getDuracao_slot();
$preco_slot = $campo->getPreco_slot(); // <-- novo campo no banco

// Valida se o horário está dentro do horário de funcionamento
if ($horarioPartida < $inicio_operacao || $horarioPartida > $fim_operacao) {
    sweetAlert('Erro', 'O horário selecionado está fora do horário de operação do campo.', 'error', '../view/home.php');
    exit;
}

// Calcula o horário final com base na duração do slot
$inicio = new DateTime($horarioPartida);
$horaFim = clone $inicio;
$horaFim->modify("+{$duracao_slot} minutes");

// Verifica se já existe uma reserva nesse horário
$existeReserva = $reservaModel->verificarConflito(
    $id_campo,
    $diaPartida,
    $inicio->format('H:i:s'),
    $horaFim->format('H:i:s')
);

if ($existeReserva) {
    sweetAlert('Erro', 'Já existe uma reserva nesse horário!', 'error', '../view/home.php');
    exit;
}

// Obtém o ID do cliente da sessão
$id_cliente = $_SESSION['id_cliente'] ?? null;
if (!$id_cliente) {
    sweetAlert('Erro', 'Você precisa estar logado para agendar.', 'error', '../view/login.html');
    exit;
}

// 🧮 Calcula o valor total da reserva
// Exemplo: se o slot for 60 minutos e o preço for R$100 → valor_total = 100
// Se o slot for 120 minutos (2 horas), valor_total = 200
$inicioCalc = new DateTime($inicio->format('H:i:s'));
$fimCalc = new DateTime($horaFim->format('H:i:s'));
$intervalo = $inicioCalc->diff($fimCalc);
$horas = $intervalo->h + ($intervalo->i / 60); // inclui minutos fracionados se houver
$valor_total = $preco_slot * $horas;

// Cria a reserva
$reservaModel->setIdCampo($id_campo);
$reservaModel->setIdCliente($id_cliente);
$reservaModel->setDataReserva($diaPartida);
$reservaModel->setHoraInicio($inicio->format('H:i:s'));
$reservaModel->setHoraFim($horaFim->format('H:i:s'));
$reservaModel->setValorTotal($valor_total);
$reservaModel->setStatus('confirmado');

if ($reservaModel->create()) {
    sweetAlert('Sucesso', 'Agendamento realizado com sucesso! Valor total: R$ ' . number_format($valor_total, 2, ',', '.'), 'success', '../view/home.php');
} else {
    sweetAlert('Erro', 'Erro ao realizar agendamento!', 'error', '../view/home.php');
}
